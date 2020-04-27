var CACHE_NAME = 'my-site-cache-v2';
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
            console.log(event.request);
            if(response){
                return response;
            } 
            if (event.request.url == '/home') {
                console.log('/home');
                return fetch(event.request).then(fetchRes => {
                    return caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request.url, fetchRes.clone());
                        return fetchRes;
                    })
                });
            }
            console.log('else')
            return fetch(event.request);
        })
    );
});

