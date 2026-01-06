import './bootstrap';

async function registerDailyReminder() {
    if (!('serviceWorker' in navigator)) return;

    const registration = await navigator.serviceWorker.ready;

    if ('periodicSync' in registration) {
        try {
            const status = await navigator.permissions.query({
                name: 'periodic-background-sync',
            });

            if (status.state === 'granted') {
                await registration.periodicSync.register('daily-reminder', {
                    minInterval: 24 * 60 * 60 * 1000, // 1 day
                });
                console.log('✅ Periodic Background Sync registered');
                return;
            }
        } catch (e) {
            console.warn('Periodic sync failed, falling back');
        }
    }

    if ('SyncManager' in window) {
        try {
            const tags = await registration.sync.getTags();
            if (!tags.includes('daily-reminder')) {
                await registration.sync.register('daily-reminder');
                console.log('⚠️ Using one-off Background Sync');
                return;
            }
        } catch (e) {
            console.warn('One-off sync failed, falling back');
        }
    }

    fallbackInPageReminder();
}

function fallbackInPageReminder() {
    if (Notification.permission !== 'granted') return;

    const LAST_KEY = 'last-diary-reminder';
    const last = Number(localStorage.getItem(LAST_KEY));
    const now = Date.now();

    if (!last || now - last > 24 * 60 * 60 * 1000) {
        new Notification('Your Daily Diary Reminder', {
            body: 'Take a moment to write your thoughts today ✍️',
            icon: '/icons/old/icons-192.png',
        });

        localStorage.setItem(LAST_KEY, now);
        console.log('📌 In-page reminder used');
    }
}

document.addEventListener(
    'click',
    async () => {
        await registerDailyReminder();
    },
    { once: true }
);


function formatRelative(date, locale) {
    const seconds = Math.floor((Date.now() - date.getTime()) / 1000);

    if (seconds < 45) {
        return locale.startsWith('en') ? 'Just now' : null;
    }

    const rtf = new Intl.RelativeTimeFormat(locale, { numeric: 'auto' });

    const divisions = [
        { amount: 60, name: 'second' },
        { amount: 60, name: 'minute' },
        { amount: 24, name: 'hour' },
        { amount: 7, name: 'day' },
        { amount: 4.34524, name: 'week' },
        { amount: 12, name: 'month' },
        { amount: Infinity, name: 'year' },
    ];

    let duration = seconds;

    for (let i = 0; i < divisions.length; i++) {
        if (Math.abs(duration) < divisions[i].amount) {
            return rtf.format(-Math.round(duration), divisions[i].name);
        }
        duration /= divisions[i].amount;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-time]').forEach(el => {
        const iso = el.dataset.time;
        const locale = navigator.language;

        const date = new Date(iso);
        if (isNaN(date)) return;

        const relative = formatRelative(date, locale);

        const absolute = date.toLocaleString(locale, {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
        });

        const target = el.querySelector('.js-date');
        if (target) {
            target.textContent = relative ?? absolute.split(',')[0];
        }

        el.title = absolute;
        el.setAttribute('datetime', date.toISOString());
    });
})
