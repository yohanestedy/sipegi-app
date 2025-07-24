const CACHE_NAME = "offline-v1";
const filesToCache = [
    "/offline.html",
    // "/404.html",
    "/assets/static/images/logo/sipegi-favicon.svg",
    "/assets/compiled/css/app-pwa.css",
    "/assets/compiled/css/error-pwa.css",
    "/assets/compiled/png/error-nointernet.png",
];

self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(filesToCache);
        })
    );
});

self.addEventListener("activate", function (event) {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.map(function (cacheName) {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Tangani fetch
self.addEventListener("fetch", function (event) {
    event.respondWith(
        fetch(event.request)
            .then(function (response) {
                // Kalau 404, arahkan ke 404.html
                if (response.status === 404) {
                    return caches.match("/404.html");
                }
                return response;
            })
            .catch(function () {
                // Kalau offline, arahkan ke offline.html
                return caches.match("/offline.html");
            })
    );

    // Simpan ke cache jika permintaan valid
    if (event.request.url.startsWith("http")) {
        event.waitUntil(
            caches.open(CACHE_NAME).then(function (cache) {
                return fetch(event.request)
                    .then((response) => {
                        if (response && response.status === 200) {
                            return cache.put(event.request, response.clone());
                        }
                    })
                    .catch(() => {});
            })
        );
    }
});
