const staticAssets = [
    '/css/app.css',
    '/js/app.js',
    '/images/logo.png',
];

self.addEventListener('install', async event => {
    const cache = await caches.open('static-assets');
    cache.addAll(staticAssets);
});

self.addEventListener('fetch', event => {
    const req = event.request;
    const url = new URL(req.url);
    event.respondWith(cacheFirst(req));
});

async function cacheFirst(req) {
    const cachedResponse = await caches.match(req);
    return cachedResponse || fetch(req);
}

async function networkFirst(req) {
    const cache = await caches.open('dynamic-assets');
    try {
        const res = await fetch(req);
        cache.put(req, res.clone());
        return res;
    } catch (e) {
        return await cache.match(req);
    }
}