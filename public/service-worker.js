const STATIC_CACHE = 'ediary-static-v7';
const PAGE_CACHE   = 'ediary-pages-v7';

const ONE_WEEK = 7 * 24 * 60 * 60 * 1000;

const CORE_ASSETS = [
    '/',
    '/home',
    '/offline.html',
    '/manifest.webmanifest',
    '/css/app.css',
    '/js/app.js',

    '/icons/svg/share.svg',
    '/icons/old/icons-24.png',
    '/icons/old/icons-36.png',
    '/icons/old/icons-48.png',
    '/icons/old/icons-72.png',
    '/icons/old/icons-120.png',
    '/icons/old/icons-144.png',
    '/icons/old/icons-192.png',
    '/icons/old/icons-512.png',

    '/blog',
    '/faq',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => cache.addAll(CORE_ASSETS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys
                    .filter(key => ![STATIC_CACHE, PAGE_CACHE].includes(key))
                    .map(key => caches.delete(key))
            )
        )
            .then(() => self.clients.claim())
            .then(registerBackgroundSync)
    );
});

self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET') return;

    const url = new URL(event.request.url);

    if (url.pathname === '/logout') {
        event.respondWith(handleLogout(event.request));
        return;
    }

    if (event.request.mode === 'navigate') {
        event.respondWith(networkFirstPage(event.request));
        return;
    }

    if (isStaticAsset(url.pathname)) {
        event.respondWith(cacheFirstStatic(event.request));
        return;
    }

    event.respondWith(networkWithFallback(event.request));
});

function isStaticAsset(pathname) {
    return pathname.match(/\.(js|css|png|jpg|jpeg|svg|webp|woff2)$/);
}

async function cacheFirstStatic(request) {
    const cache = await caches.open(STATIC_CACHE);
    const cached = await cache.match(request);

    if (cached && !isExpired(cached)) {
        revalidateStatic(request, cache);
        return cached;
    }

    const fresh = await fetch(request);
    await putWithTimestamp(cache, request, fresh.clone());
    return fresh;
}

async function networkFirstPage(request) {
    const cache = await caches.open(PAGE_CACHE);

    try {
        const fresh = await fetch(request);
        await putWithTimestamp(cache, request, fresh.clone());
        reCacheHomeVariants();
        return fresh;
    } catch {
        return (
            (await cache.match(request)) ||
            (await caches.match('/offline.html'))
        );
    }
}

async function networkWithFallback(request) {
    try {
        return await fetch(request);
    } catch {
        if (request.mode === 'navigate') {
            return caches.match('/offline.html');
        }
        throw new Error('Network failed');
    }
}

function isExpired(response) {
    const time = response.headers.get('sw-cache-time');
    if (!time) return true;
    return Date.now() - Number(time) > ONE_WEEK;
}

async function putWithTimestamp(cache, request, response) {
    const headers = new Headers(response.headers);
    headers.set('sw-cache-time', Date.now().toString());

    const timedResponse = new Response(await response.clone().blob(), {
        status: response.status,
        statusText: response.statusText,
        headers
    });

    await cache.put(request, timedResponse);
}

function revalidateStatic(request, cache) {
    const ext = request.url.split('.').pop();

    // JS & CSS → revalidate aggressively
    if (ext === 'js' || ext === 'css') {
        fetch(request).then(res => {
            if (res.ok) putWithTimestamp(cache, request, res);
        }).catch(() => {});
        return;
    }

    // Images → revalidate lazily
    setTimeout(() => {
        fetch(request).then(res => {
            if (res.ok) putWithTimestamp(cache, request, res);
        }).catch(() => {});
    }, 3000);
}

async function handleLogout(request) {
    const response = await fetch(request);
    if (response.status === 204) {
        const cache = await caches.open(PAGE_CACHE);
        await cache.delete('/home');
    }
    return response;
}

function reCacheHomeVariants() {
    const variants = ['/', '/?utm_source=homescreen'];
    variants.forEach(path => {
        fetch(path).then(res => {
            caches.open(PAGE_CACHE)
                .then(cache => putWithTimestamp(cache, path, res));
        });
    });
}

self.addEventListener('sync', event => {
    if (event.tag === 'sync-diary-entries') {
        event.waitUntil(syncOfflineEntries());
    }

    if (event.tag === 'daily-reminder') {
        event.waitUntil(sendDailyReminder());
    }
});

async function syncOfflineEntries() {
    const clients = await self.clients.matchAll();
    clients.forEach(client =>
        client.postMessage({
            type: 'SYNC_REQUIRED',
            message: 'Connection restored. Syncing offline entries...'
        })
    );
}

async function registerBackgroundSync() {
    if ('SyncManager' in self.registration) {
        try {
            await self.registration.sync.register('daily-reminder');
        } catch (_) {}
    }
}

async function sendDailyReminder() {
    if (Notification.permission !== 'granted') return;

    const hour = new Date().getHours();
    const message =
        hour < 12
            ? "Good morning! 🌅 Time to write your thoughts."
            : hour < 18
                ? "Hello! 🌞 Take a moment to reflect in your diary."
                : "Good evening! 🌙 End your day with a diary note.";

    await self.registration.showNotification('Your Daily Diary Reminder', {
        body: message,
        icon: '/icons/old/icons-192.png',
        badge: '/icons/old/icons-24.png',
        tag: 'diary-reminder',
        requireInteraction: true,
        data: { url: '/home' }
    });
}

self.addEventListener('notificationclick', event => {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data.url));
});
