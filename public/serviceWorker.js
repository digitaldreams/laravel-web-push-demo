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

self.addEventListener('push', event => {
    var data = event.data.json();
    var promise = self.registration.showNotification(data.title, data);
    event.waitUntil(promise);
});

self.addEventListener('notificationclick', function (event) {
    const clickedNotification = event.notification;
    let url = '';
    if (typeof clickedNotification.data !== 'undefined' && typeof clickedNotification.data.url !== 'undefined') {
        url = clickedNotification.data.url;
    }
    clickedNotification.close();
    event.waitUntil(
        clients.matchAll({type: 'window'}).then(windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                // If so, just focus it.
                if (client.url === url && 'focus' in client) {
                    return client.focus().reload();
                }
            }
            // If not, then open the target URL in a new window/tab.
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});