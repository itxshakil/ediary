import { track } from './analytics';

const DAY = 24 * 60 * 60 * 1000;

const COPY = {
    A: {
        title: 'Install Ediary 📓',
        body: 'Write offline, faster access, private.',
        cta: 'Install App',
        icon: '/icons/android-icon-192x192.png',
    },
    B: {
        title: 'Make Ediary your daily habit ✨',
        body: 'Install it for one-tap writing, even offline.',
        cta: 'Add to Home Screen',
        icon: '/icons/android-icon-192x192.png',
    },
};

let deferredPrompt = null;

const now = () => Date.now();
const isIOS = () => /iphone|ipad|ipod/i.test(navigator.userAgent);
const isStandalone = () => window.navigator.standalone === true;

function trackVisits() {
    const today = new Date().toISOString().slice(0, 10);
    const visits = JSON.parse(localStorage.getItem('pwa:visit_days') || '[]');

    if (!visits.includes(today)) {
        visits.push(today);
        localStorage.setItem('pwa:visit_days', JSON.stringify(visits));
    }
}

function getVariant() {
    let variant = localStorage.getItem('pwa:variant');

    if (!variant) {
        variant = Math.random() < 0.5 ? 'A' : 'B';
        localStorage.setItem('pwa:variant', variant);
    }

    return variant;
}

/**
 * Asks the browser to wake the worker about once a day for an evening reminder (see
 * service-worker.js). Only installed apps that allowed notifications get it; email reminders
 * are the dependable channel for everyone else.
 */
async function registerDailyReminder() {
    if (!('serviceWorker' in navigator) || !('Notification' in window) || Notification.permission !== 'granted') {
        return;
    }

    const registration = await navigator.serviceWorker.ready;
    if (!('periodicSync' in registration)) {
        return;
    }

    try {
        const status = await navigator.permissions.query({ name: 'periodic-background-sync' });
        if (status.state === 'granted') {
            await registration.periodicSync.register('daily-reminder', { minInterval: DAY });
        }
    } catch (error) {
        console.warn('Could not schedule the daily reminder:', error);
    }
}

function applyCopy() {
    const copy = COPY[getVariant()];
    const title = document.getElementById('pwa-banner-title');
    const body = document.getElementById('pwa-banner-body');
    const cta = document.getElementById('pwa-banner-cta');
    const icon = document.getElementById('pwa-banner-icon');

    if (!title || !body || !cta || !icon) {
        return;
    }

    if (isIOS() && !isStandalone()) {
        title.textContent = 'Add Ediary to Home Screen';
        body.textContent = 'Tap the Share icon → Add to Home Screen for quick access & reminders.';
        cta.textContent = 'How to Add';
        icon.src = '/icons/apple-icon-180x180.png';

        return;
    }

    title.textContent = copy.title;
    body.textContent = copy.body;
    cta.textContent = copy.cta;
    icon.src = copy.icon;
}

function hideBanner() {
    const banner = document.getElementById('pwa-banner');

    if (!banner) {
        return;
    }

    banner.classList.remove('pwa-visible');
    banner.addEventListener('transitionend', () => banner.classList.add('hidden'), { once: true });
}

function maybeShowBanner() {
    if (localStorage.getItem('pwa:installed')) {
        return;
    }

    const stay = localStorage.getItem('pwa:stay_10s');
    const visits = JSON.parse(localStorage.getItem('pwa:visit_days') || '[]');
    const entries = Number(localStorage.getItem('pwa:entry_count') || 0);
    const dismissed = Number(localStorage.getItem('pwa:banner_dismissed') || 0);
    // Someone who has saved an entry is the likeliest to want the app; otherwise wait for a return visit.
    const interested = entries >= 1 || (stay && visits.length >= 2);

    if (!interested || now() - dismissed <= 7 * DAY) {
        return;
    }

    const banner = document.getElementById('pwa-banner');

    if (!banner) {
        return;
    }

    // Toasts sit in the same spot (e.g. "Entry saved"); wait for them to go instead of covering them.
    const toasts = document.getElementById('toasts');
    if (toasts?.childElementCount) {
        const observer = new MutationObserver(() => {
            if (toasts.childElementCount === 0) {
                observer.disconnect();
                maybeShowBanner();
            }
        });
        observer.observe(toasts, { childList: true });

        return;
    }

    if (!banner.classList.contains('hidden')) {
        return;
    }

    applyCopy();
    banner.classList.remove('hidden');
    requestAnimationFrame(() => banner.classList.add('pwa-visible'));
    track('pwa_banner_shown', { variant: getVariant() });
}

async function showNotificationPrompt() {
    if (!('Notification' in window)) {
        return;
    }

    const lastAsk = Number(localStorage.getItem('pwa:notif_asked') || 0);

    if (Notification.permission === 'default' && now() - lastAsk > 7 * DAY) {
        localStorage.setItem('pwa:notif_asked', String(now()));

        try {
            const permission = await Notification.requestPermission();
            track('notification_permission', { permission });

            if (permission === 'granted') {
                await registerDailyReminder();
            }
        } catch {
            // Ignore prompt failures.
        }

        return;
    }

    if (Notification.permission === 'granted') {
        await registerDailyReminder();
    }
}

function incrementEntryCount() {
    const count = Number(localStorage.getItem('pwa:entry_count') || 0) + 1;
    localStorage.setItem('pwa:entry_count', String(count));
}

function bindBannerActions() {
    document.getElementById('pwa-banner-cta')?.addEventListener('click', async () => {
        track('pwa_banner_clicked');

        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;

            if (outcome === 'accepted') {
                localStorage.setItem('pwa:installed', '1');
                track('pwa_install_accepted');
            } else {
                track('pwa_install_rejected');
            }

            deferredPrompt = null;
            hideBanner();

            return;
        }

        if (isIOS() && !isStandalone()) {
            window.toast?.({ type: 'info', title: 'Install Ediary', message: 'Tap the Share icon, then Add to Home Screen.' });

            return;
        }

        await showNotificationPrompt();
    });

    document.getElementById('pwa-banner-dismiss')?.addEventListener('click', () => {
        localStorage.setItem('pwa:banner_dismissed', String(now()));
        track('pwa_banner_dismissed');
        hideBanner();
    });
}

export function initPwaExperience() {
    trackVisits();
    registerDailyReminder();

    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        deferredPrompt = event;
    });

    window.addEventListener('appinstalled', () => localStorage.setItem('pwa:installed', '1'));

    setTimeout(() => {
        localStorage.setItem('pwa:stay_10s', '1');
        maybeShowBanner();
    }, 10000);

    // New entries only: the edit form is data-entry-form="edit".
    document.querySelectorAll('form[data-entry-form=""]').forEach((form) => form.addEventListener('submit', incrementEntryCount));

    bindBannerActions();
    maybeShowBanner();
}
