const DAY = 24 * 60 * 60 * 1000;

const COPY = {
    A: {
        title: 'Install Ediary 📓',
        body: 'Write offline, faster access, private.',
        cta: 'Install App',
        icon: '/icons/android-icon-192x192.png',
    },
    B: {
        title: 'Make Ediary your Daily Habit ✨',
        body: 'Install & get daily reminders.',
        cta: 'Add to Home Screen',
        icon: '/icons/android-icon-192x192.png',
    },
};

let deferredPrompt = null;

const now = () => Date.now();
const isIOS = () => /iphone|ipad|ipod/i.test(navigator.userAgent);
const isStandalone = () => window.navigator.standalone === true;

const trackGA = (event, params = {}) => {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event, ...params });
};

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

function reminderContent() {
    const hour = new Date().getHours();

    if (hour < 12) {
        return {
            title: 'Good morning! 🌅',
            body: 'Start your day by jotting down your thoughts.',
        };
    }

    if (hour < 18) {
        return {
            title: 'Time for a break? 🌞',
            body: 'How is your day going? Take a moment to reflect.',
        };
    }

    return {
        title: 'Good evening! 🌙',
        body: 'Unwind and record your memories of today.',
    };
}

function fallbackNotification() {
    if (Notification.permission !== 'granted') {
        return;
    }

    const lastKey = 'last-diary-reminder';
    const last = Number(localStorage.getItem(lastKey) || 0);
    const current = now();
    const reminder = reminderContent();

    if (!last || current - last > DAY) {
        new Notification(reminder.title, {
            body: reminder.body,
            icon: '/icons/android-icon-192x192.png',
        });

        localStorage.setItem(lastKey, String(current));
        trackGA('daily_reminder_fallback');
    }
}

async function registerDailyReminder() {
    if (!('serviceWorker' in navigator)) {
        return;
    }

    const registration = await navigator.serviceWorker.ready;

    if ('periodicSync' in registration) {
        try {
            const status = await navigator.permissions.query({
                name: 'periodic-background-sync',
            });

            if (status.state === 'granted') {
                await registration.periodicSync.register('daily-reminder', {
                    minInterval: DAY,
                });

                return;
            }
        } catch {
            // Fall through to the next supported option.
        }
    }

    if ('SyncManager' in window) {
        try {
            const tags = await registration.sync.getTags();

            if (!tags.includes('daily-reminder')) {
                await registration.sync.register('daily-reminder');

                return;
            }
        } catch {
            // Fall through to in-page notifications.
        }
    }

    fallbackNotification();
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
    if (localStorage.getItem('pwa:installed') || localStorage.getItem('pwa:banner_disabled')) {
        return;
    }

    const stay = localStorage.getItem('pwa:stay_10s');
    const visits = JSON.parse(localStorage.getItem('pwa:visit_days') || '[]');
    const dismissed = Number(localStorage.getItem('pwa:banner_dismissed') || 0);

    if (!stay || visits.length < 2 || now() - dismissed <= 7 * DAY) {
        return;
    }

    const banner = document.getElementById('pwa-banner');

    if (!banner) {
        return;
    }

    applyCopy();
    banner.classList.remove('hidden');
    requestAnimationFrame(() => banner.classList.add('pwa-visible'));
    trackGA('pwa_banner_shown', { variant: getVariant() });
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
            trackGA('notification_permission', { permission });

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

    if (count >= 3) {
        localStorage.setItem('pwa:banner_disabled', '1');
    }
}

function bindBannerActions() {
    document.getElementById('pwa-banner-cta')?.addEventListener('click', async () => {
        trackGA('pwa_banner_clicked');

        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;

            if (outcome === 'accepted') {
                localStorage.setItem('pwa:installed', '1');
                trackGA('pwa_install_accepted');
            } else {
                trackGA('pwa_install_rejected');
            }

            deferredPrompt = null;
            hideBanner();

            return;
        }

        if (isIOS() && !isStandalone()) {
            alert('Tap the Share icon → Add to Home Screen to install Ediary.');

            return;
        }

        await showNotificationPrompt();
    });

    document.getElementById('pwa-banner-dismiss')?.addEventListener('click', () => {
        localStorage.setItem('pwa:banner_dismissed', String(now()));
        trackGA('pwa_banner_dismissed');
        hideBanner();
    });
}

export function initPwaExperience() {
    trackVisits();

    document.addEventListener(
        'click',
        async () => {
            await registerDailyReminder();
        },
        { once: true }
    );

    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        deferredPrompt = event;
    });

    window.addEventListener('appinstalled', () => localStorage.setItem('pwa:installed', '1'));

    setTimeout(() => {
        localStorage.setItem('pwa:stay_10s', '1');
        maybeShowBanner();
    }, 10000);

    document.getElementById('diary-form')?.addEventListener('submit', () => {
        incrementEntryCount();
    });

    bindBannerActions();
    maybeShowBanner();
}
