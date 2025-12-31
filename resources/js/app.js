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

