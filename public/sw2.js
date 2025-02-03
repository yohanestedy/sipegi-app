const CACHE_NAME = "offline-v1"; // Ganti versi jika ada perubahan
const filesToCache = [
    "/",
    "/offline.html",
    "/assets/static/images/logo/sipegi-favicon.svg",
    "/assets/compiled/css/app.css",
    "/assets/compiled/css/error.css",
    "/assets/compiled/png/error-nointernet.png",
];

// Preload cache saat install
const preLoad = function () {
    return caches.open(CACHE_NAME).then(function (cache) {
        return cache.addAll(filesToCache);
    });
};

self.addEventListener("install", function (event) {
    event.waitUntil(preLoad());
});

// Menghapus cache lama saat update
self.addEventListener("activate", function (event) {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.map(function (cacheName) {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Memeriksa respons dari jaringan
const checkResponse = function (request) {
    return new Promise(function (fulfill, reject) {
        fetch(request).then(function (response) {
            if (response.status !== 404) {
                fulfill(response);
            } else {
                reject();
            }
        }, reject);
    });
};

// Menambahkan ke cache
const addToCache = function (request) {
    return caches.open(CACHE_NAME).then(function (cache) {
        return fetch(request).then(function (response) {
            return cache.put(request, response.clone());
        });
    });
};

// Mengembalikan dari cache
const returnFromCache = function (request) {
    return caches.open(CACHE_NAME).then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (!matching || matching.status === 404) {
                return cache.match("offline.html");
            } else {
                return matching;
            }
        });
    });
};

// Menangani permintaan fetch
self.addEventListener("fetch", function (event) {
    event.respondWith(
        checkResponse(event.request).catch(function () {
            return returnFromCache(event.request);
        })
    );

    // Hanya cache permintaan yang bukan dari http
    if (!event.request.url.startsWith("http")) {
        event.waitUntil(addToCache(event.request));
    }
});
