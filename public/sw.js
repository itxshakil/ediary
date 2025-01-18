const CACHE_NAME = 'ediary-cache-v5';
const urlsToCache = [
    '/',
    '/?utm_source=homescreen',
    '/css/app.css',
    '/js/app.js',
    '/manifest.webmanifest',
    '/icons/svg/share.svg',
    '/icons/old/icons-192.png',
    '/icons/old/icons-24.png',
    '/icons/old/icons-36.png',
    '/icons/old/icons-48.png',
    '/icons/old/icons-72.png',
    '/icons/old/icons-144.png',
    '/icons/old/icons-120.png',
    '/icons/old/icons-512.png',
    '/blog',
    '/faq',
    '/search?utm_source=homescreen',
    '/images/screenshots/ediary-features.png',
    '/images/screenshots/ediary-profile.png',
    '/images/screenshots/ediary-welcome.png',
    '/images/screenshots/ediary-blogs.png',
];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function (cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(keys
                .filter(key => key !== CACHE_NAME)
                .map(key => caches.delete(key))
            );
        })
    );
});

self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request)
        .then(function (response) {
            if (response) {
                return response;
            }
            const url = new URL(event.request.url);
            if (url.pathname === '/home') {
                return fetch(event.request)
                    .then(fetchRes => {
                        return caches.open(CACHE_NAME)
                            .then(cache => {
                                cache.put(event.request.url, fetchRes.clone());
                                reCacheHomePage();
                                return fetchRes;
                            })
                    });
            }
            if (url.pathname === '/logout') {
                return fetch(event.request).then(fetchRes => {
                    if (fetchRes.status === 204) {
                        return caches.open(CACHE_NAME)
                            .then(cache => {
                                cache.delete('/home');
                                return fetchRes;
                            })
                    }
                    return fetchRes;
                });
            }
            try {
                return fetch(event.request);
            } catch (err) {
                // If this was a navigation, show the offline page:
                if (request.mode === 'navigate') {
                    return caches.match('/');
                }

                // Otherwise throw
                throw err;
            }
        })
    );
});

function reCacheHomePage() {
    const homePages = ['/', '/?utm_source=homescreen'];
    homePages.forEach(page => {
        fetch(page).then(newRes => {
            caches.open(CACHE_NAME).then(cache => {
                cache.put(page, newRes.clone());
            })
        });
    })
}

async function sendDailyReminder() {
    if (Notification.permission === 'granted') {
        const now = new Date();
        let message = '';

        // Customize message based on the time of day
        if (now.getHours() < 12) {
            message = "Good morning! 🌅 It's a perfect time to jot down your thoughts in your diary.";
        } else if (now.getHours() < 18) {
            message = "Hello! 🌞 How’s your day been so far? Take a moment to reflect in your diary.";
        } else {
            message = "Good evening! 🌙 End your day by writing down your thoughts in your diary.";
        }

        // Send notification with the personalized message
        await self.registration.showNotification("Your Daily Diary Reminder", {
            body: message,
            icon: '/icons/old/icons-192.png',
            badge: '/icons/old/icons-24.png',
            tag: 'diary-reminder',
            requireInteraction: true,
            vibrate: [200, 100, 200],
            data: {
                url: '/home'  // Redirect URL when user clicks the notification
            }
        });
    } else {
        await Notification.requestPermission();
    }
}

self.addEventListener('notificationclick', function(event) {
    const notification = event.notification;
    const url = notification.data.url;

    // Open the app's diary page when the notification is clicked
    event.waitUntil(
        clients.openWindow(url)  // Opens the diary page (or any relevant page)
            .then(() => notification.close())  // Close the notification after click
    );
});

self.addEventListener('sync', function(event) {
    if (event.tag === 'daily-reminder') {
        event.waitUntil(sendDailyReminder());
    }
});

// Request Background Sync for the reminder
function registerBackgroundSync() {
    if ('SyncManager' in self) {
        self.registration.sync.register('daily-reminder')
            .catch(err => console.error('Background sync registration failed:', err));
    }
}

// Register background sync when the service worker is ready
self.addEventListener('activate', (event) => {
    event.waitUntil(registerBackgroundSync());
});
