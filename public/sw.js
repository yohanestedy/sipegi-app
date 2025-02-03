const CACHE_NAME = "offline-v1"; // Ganti versi jika ada perubahan
const filesToCache = [
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
                        return caches.delete(cacheName); // Hapus cache yang tidak ada dalam whitelist
                    }
                })
            );
        })
    );
});

// Menangani permintaan fetch dengan Stale-While-Revalidate
self.addEventListener("fetch", function (event) {
    event.respondWith(
        caches
            .match(event.request)
            .then(function (cachedResponse) {
                // Kembalikan data dari cache jika ada
                if (cachedResponse) {
                    // Lakukan permintaan ke jaringan untuk memeriksa pembaruan
                    fetch(event.request).then(function (response) {
                        // Perbarui cache dengan data baru jika respons berhasil
                        if (response && response.status === 200) {
                            caches.open(CACHE_NAME).then(function (cache) {
                                cache.put(event.request, response.clone());
                            });
                        }
                    });
                    return cachedResponse; // Kembalikan data dari cache
                }

                // Jika tidak ada cache, ambil dari jaringan
                return fetch(event.request).then(function (response) {
                    // Perbarui cache dengan data baru jika respons berhasil
                    if (response && response.status === 200) {
                        return caches.open(CACHE_NAME).then(function (cache) {
                            cache.put(event.request, response.clone());
                            return response; // Kembalikan respons dari jaringan
                        });
                    }
                    return response; // Kembalikan respons jika tidak ada cache
                });
            })
            .catch(function () {
                // Kembalikan halaman offline jika jaringan gagal
                return caches.match("/offline.html");
            })
    );
});
