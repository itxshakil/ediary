var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/icons/old/icons-192.png',
    '/icons/old/icons-24.png',
    '/icons/old/icons-36.png',
    '/icons/old/icons-48.png',
    '/icons/old/icons-72.png',
    '/icons/old/icons-144.png',
    '/icons/old/icons-120.png',
    '/icons/old/icons-512.png',
    'https://source.unsplash.com/K4mSJ7kc0As/600x800'
];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function (cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

// fetch
self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            return response || fetch(event.request);
        })
    );
});

