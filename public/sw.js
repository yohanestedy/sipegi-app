const CACHE_NAME = "offline-v2";
const filesToCache = [
    "/offline.html",
    "/assets/static/images/logo/sipegi-favicon.svg",
    "/assets/compiled/css/app-pwa.css",
    "/assets/compiled/css/error-pwa.css",
    "/assets/compiled/png/error-nointernet.png",
    "/assets/compiled/fonts/nunito-latin-400-normal.woff2",
    "/assets/compiled/fonts/nunito-latin-600-normal.woff2",
    "/assets/compiled/fonts/nunito-latin-700-normal.woff2",
    "/assets/compiled/fonts/nunito-latin-800-normal.woff2",
];

// Cache file statis saat install
self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(filesToCache);
        })
    );
});

// Hapus cache lama saat activate
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

// Tangani fetch request
self.addEventListener("fetch", function (event) {
    event.respondWith(
        fetch(event.request).catch(function () {
            // Saat offline, tampilkan halaman offline
            return caches.match("/offline.html");
        })
    );
});
