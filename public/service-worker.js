// Generated on `npm run build` from Vite's manifest; see scripts/generate-sw-precache.mjs.
try {
    importScripts('/build/sw-precache.js');
} catch (error) {
    console.warn('No build manifest found; precaching core assets only.', error);
}

const BUILD = self.__EDIARY_BUILD ?? { version: 'dev', assets: [] };
// Hashed build files: a new build gets a new cache. Icons, manifest and the offline page rarely
// change, so they live in a stable cache (bump CORE_CACHE when one of them does).
const STATIC_CACHE = `ediary-static-${BUILD.version}`;
const CORE_CACHE   = 'ediary-core-v1';
const PAGE_CACHE   = 'ediary-pages-v12';

const ONE_WEEK = 7 * 24 * 60 * 60 * 1000;

const CORE_PAGES = ['/', '/home', '/blog', '/faq'];

const CORE_FILES = [
    '/offline.html',
    '/manifest.webmanifest',

    '/icons/svg/share.svg',
    '/icons/old/icons-24.png',
    '/icons/old/icons-36.png',
    '/icons/old/icons-48.png',
    '/icons/old/icons-72.png',
    '/icons/old/icons-120.png',
    '/icons/old/icons-144.png',
    '/icons/old/icons-192.png',
    '/icons/old/icons-512.png',
];

self.addEventListener('install', event => {
    event.waitUntil(
        Promise.all([
            precache(STATIC_CACHE, BUILD.assets),
            precache(CORE_CACHE, CORE_FILES),
            precache(PAGE_CACHE, CORE_PAGES),
        ]).then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys
                    .filter(key => ![STATIC_CACHE, CORE_CACHE, PAGE_CACHE].includes(key))
                    .map(key => caches.delete(key))
            )
        )
            .then(() => self.clients.claim())
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
    // Content-hashed build files never change, so they are never revalidated or expired.
    const hashed = new URL(request.url).pathname.startsWith('/build/');
    const cache = await caches.open(hashed ? STATIC_CACHE : CORE_CACHE);
    const cached = await caches.match(request);

    if (cached && (hashed || !isExpired(cached))) {
        if (!hashed) revalidateStatic(request, cache);
        return cached;
    }

    try {
        const fresh = await fetch(request);
        if (fresh.ok) {
            await putWithTimestamp(cache, request, fresh.clone());
        }
        return fresh;
    } catch (error) {
        // Offline: a stale copy beats a page without its styles or scripts.
        if (cached) return cached;
        throw error;
    }
}

// Fetches only what the cache doesn't already hold, so a new build doesn't re-download unchanged files.
async function precache(cacheName, urls) {
    const cache = await caches.open(cacheName);
    const missing = (await Promise.all(urls.map(async url => ((await cache.match(url)) ? null : url)))).filter(Boolean);

    await Promise.all(missing.map(async url => {
        const response = await fetch(url, { cache: 'reload' });
        if (!response.ok) {
            throw new Error(`Precache failed for ${url}: ${response.status}`);
        }
        // e.g. /home redirects guests to /login; don't store the login page as /home.
        if (response.redirected) return;
        await putWithTimestamp(cache, url, response);
    }));
}

async function networkFirstPage(request) {
    const cache = await caches.open(PAGE_CACHE);

    try {
        const fresh = await fetch(request);
        // A redirected response can't answer a navigation later (e.g. "/" sends signed-in people to /home).
        if (fresh.ok && !fresh.redirected) {
            await putWithTimestamp(cache, request, fresh.clone());
        }
        return fresh;
    } catch {
        // The installed app opens /home?utm_source=homescreen; offline, the cached /home will do.
        return (
            (await cache.match(request)) ||
            (await cache.match(request, { ignoreSearch: true })) ||
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

self.addEventListener('sync', event => {
    if (event.tag === 'sync-diary-entries') {
        event.waitUntil(syncOfflineEntries());
    }
});

// Installed apps with notifications allowed register this about once a day (see pwa.js). The
// browser picks the time, so only remind in the evening, when an entry is most likely.
self.addEventListener('periodicsync', event => {
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

async function sendDailyReminder() {
    const hour = new Date().getHours();
    if (Notification.permission !== 'granted' || hour < 18 || hour >= 23) return;

    await self.registration.showNotification('A few lines tonight? 🌙', {
        body: 'Take a minute to write about your day.',
        icon: '/icons/android-icon-192x192.png',
        tag: 'diary-reminder',
        data: { url: '/diaries/create?utm_source=notification' }
    });
}

self.addEventListener('notificationclick', event => {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data.url));
});
