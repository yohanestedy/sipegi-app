// Versi cache
const CACHE_NAME = "offline-v2"; // Ganti versi cache jika ada perubahan
const filesToCache = [
    "/",
    "/offline.html",
    // Tambahkan file statis lainnya yang perlu di-cache
];

// Fungsi untuk memuat cache
const preLoad = function () {
    return caches.open(CACHE_NAME).then(function (cache) {
        // Caching index dan rute penting
        return cache.addAll(filesToCache);
    });
};

// Event listener untuk install
self.addEventListener("install", function (event) {
    event.waitUntil(preLoad());
});

// Fungsi untuk memeriksa respons
const checkResponse = function (request) {
    return new Promise(function (fulfill, reject) {
        fetch(request)
            .then(function (response) {
                if (response.status !== 404) {
                    // Jika respons berhasil, simpan ke cache
                    caches.open(CACHE_NAME).then(function (cache) {
                        cache.put(request, response.clone());
                    });
                    fulfill(response);
                } else {
                    reject();
                }
            })
            .catch(function () {
                reject();
            });
    });
};

// Event listener untuk fetch
self.addEventListener("fetch", function (event) {
    event.respondWith(
        checkResponse(event.request).catch(function () {
            // Jika fetch gagal, coba ambil dari cache
            return caches.match(event.request).then(function (response) {
                return response || caches.match("/offline.html"); // Kembalikan halaman offline jika tidak ada di cache
            });
        })
    );
});
