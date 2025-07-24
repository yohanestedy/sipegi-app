const CACHE_NAME = "offline-v2";
const filesToCache = [
    "/offline.html",
    // "/404.html",
    "/assets/static/images/logo/sipegi-favicon.svg",
    // "assets/compiled/svg/error-404.svg",
    "/assets/compiled/css/app-pwa.css",
    "/assets/compiled/css/error-pwa.css",
    "/assets/compiled/png/error-nointernet.png",
    "/assets/compiled/fonts/nunito-latin-400-normal.woff2",
    "/assets/compiled/fonts/nunito-latin-600-normal.woff2",
    "/assets/compiled/fonts/nunito-latin-700-normal.woff2",
    "/assets/compiled/fonts/nunito-latin-800-normal.woff2",
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
        fetch(event.request).catch(function () {
            // Kalau offline, tampilkan offline.html
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
