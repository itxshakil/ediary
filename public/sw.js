var CACHE_NAME = 'my-site-cache-v3';
var urlsToCache = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/manifest.json',
    '/sw.js',
    '/icons/svg/share.svg',
    '/icons/old/icons-192.png',
    '/icons/old/icons-24.png',
    '/icons/old/icons-36.png',
    '/icons/old/icons-48.png',
    '/icons/old/icons-72.png',
    '/icons/old/icons-144.png',
    '/icons/old/icons-120.png',
    '/icons/old/icons-512.png',
];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function (cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

// activate
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

// fetch
self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            if (response) {
                return response;
            }
            let url = new URL(event.request.url);
            if (url.pathname == '/home') {
                return fetch(event.request).then(fetchRes => {
                    return caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request.url, fetchRes.clone());
                        reCacheHomePage();
                        return fetchRes;
                    })
                });
            }
            if (url.pathname == '/logout') {
                return fetch(event.request).then(fetchRes => {
                    if (fetchRes.status === 204) {
                        return caches.open(CACHE_NAME).then(cache => {
                            cache.delete('/home', fetchRes.clone());
                            return fetchRes;
                        })
                    }
                    return fetchRes;
                });
            }
            return fetch(event.request);
        })
    );
});

function reCacheHomePage() {
    fetch('/').then(newRes => {
        caches.open(CACHE_NAME).then(cache => {
            cache.put('/', newRes.clone());
        })
    });
}
