const CACHE_NAME = "baleide-v1";
const STATIC_ASSETS = [
    "/",
    "/ebook",
    "/artikel",
    "/manifest.json",
    "/assets/img/logo-black.png",
    "/assets/img/logo-baleide-white.webp",
    "/client/assets/css/bootstrap.min.css",
    "/client/assets/css/main.css",
];

// Install: cache aset statis
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(STATIC_ASSETS).catch(() => {
                // Lanjutkan meski ada aset yang gagal di-cache
            });
        }),
    );
    self.skipWaiting();
});

// Activate: hapus cache lama
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches
            .keys()
            .then((keys) =>
                Promise.all(
                    keys
                        .filter((key) => key !== CACHE_NAME)
                        .map((key) => caches.delete(key)),
                ),
            ),
    );
    self.clients.claim();
});

// Fetch: strategi Network First, fallback ke cache
self.addEventListener("fetch", (event) => {
    // Hanya handle GET request
    if (event.request.method !== "GET") return;

    // Jangan cache request ke API/checkout/admin
    const url = new URL(event.request.url);
    if (
        url.pathname.startsWith("/admin") ||
        url.pathname.startsWith("/checkout") ||
        url.pathname.startsWith("/midtrans") ||
        url.pathname.startsWith("/api")
    ) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Simpan salinan ke cache jika berhasil
                if (response && response.status === 200) {
                    const responseClone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                }
                return response;
            })
            .catch(() => {
                // Fallback ke cache jika offline
                return caches.match(event.request).then((cached) => {
                    if (cached) return cached;
                    // Fallback halaman offline untuk navigasi
                    if (event.request.mode === "navigate") {
                        return caches.match("/");
                    }
                });
            }),
    );
});
