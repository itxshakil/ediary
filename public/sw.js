const CACHE_NAME = 'ediary-cache-v4';
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
    //console.log('service worker activated');
    event.waitUntil(
        caches.keys().then(keys => {
            //console.log(keys);
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
