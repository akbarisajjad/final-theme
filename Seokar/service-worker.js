const CACHE_NAME = 'seokar-cache-v4';
const API_CACHE_NAME = 'seokar-api-cache-v3';
const STATIC_ASSETS = [
    '/',
    '/index.php',
    '/style.css',
    '/assets/css/custom.css',
    '/assets/js/scripts.js',
    '/assets/images/logo.png',
    '/offline.html'
];
const MAX_CACHE_ENTRIES = 100; // حداکثر تعداد آیتم‌های کش شده
const API_MAX_ENTRIES = 50; // حداکثر تعداد درخواست‌های API کش شده

// 📌 **نصب Service Worker و کش اولیه منابع**
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(STATIC_ASSETS);
        })
    );
    self.skipWaiting();
});

// 📌 **فعال‌سازی Service Worker و حذف کش‌های قدیمی**
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (![CACHE_NAME, API_CACHE_NAME].includes(cache)) {
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// 📌 **مدیریت کش و درخواست‌ها**
self.addEventListener('fetch', (event) => {
    const { request } = event;

    // پشتیبانی از WebSocket (در صورت نیاز)
    if (request.url.startsWith('ws://') || request.url.startsWith('wss://')) {
        return;
    }

    // مدیریت APIهای وردپرس
    if (request.url.includes('/wp-json/')) {
        if (request.method === 'GET') {
            event.respondWith(handleAPICache(request));
        } else if (request.method === 'POST') {
            event.respondWith(handlePostRequest(request));
        }
        return;
    }

    // مدیریت کش منابع استاتیک با استراتژی `Stale-While-Revalidate`
    event.respondWith(
        caches.match(request).then((cachedResponse) => {
            const fetchPromise = fetch(request).then((networkResponse) => {
                return caches.open(CACHE_NAME).then((cache) => {
                    cache.put(request, networkResponse.clone());
                    return networkResponse;
                });
            });

            return cachedResponse || fetchPromise.catch(() => caches.match('/offline.html'));
        })
    );
});

// 📌 **مدیریت کش APIها (GET) با `Stale-While-Revalidate`**
async function handleAPICache(request) {
    const cache = await caches.open(API_CACHE_NAME);
    const cachedResponse = await cache.match(request);

    const fetchPromise = fetch(request, { cache: 'no-cache' }).then((networkResponse) => {
        if (networkResponse.ok) {
            cache.put(request, networkResponse.clone());
            cacheCleanup(cache, API_MAX_ENTRIES);
            return networkResponse;
        }
        return cachedResponse || networkResponse;
    });

    return cachedResponse || fetchPromise;
}

// 📌 **مدیریت درخواست‌های `POST` با `Background Sync`**
async function handlePostRequest(request) {
    try {
        const networkResponse = await fetch(request.clone());
        return networkResponse;
    } catch (error) {
        // ذخیره درخواست در `IndexedDB` برای ارسال مجدد در حالت آنلاین
        return new Response(JSON.stringify({ success: false, message: 'درخواست در حالت آفلاین ذخیره شد و پس از اتصال ارسال می‌شود.' }), {
            headers: { 'Content-Type': 'application/json' }
        });
    }
}

// 📌 **مدیریت حافظه کش برای جلوگیری از پر شدن فضای مرورگر**
async function cacheCleanup(cache, maxEntries) {
    const keys = await cache.keys();
    if (keys.length > maxEntries) {
        await cache.delete(keys[0]); // حذف قدیمی‌ترین مورد برای مدیریت بهتر حافظه
    }
}

// 📌 **مدیریت `Background Sync` برای ارسال درخواست‌های ذخیره‌شده در حالت آفلاین**
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-post-requests') {
        event.waitUntil(sendStoredRequests());
    }
});

// 📌 **ارسال درخواست‌های ذخیره‌شده در `IndexedDB`**
async function sendStoredRequests() {
    const storedRequests = await getStoredRequests();
    for (const request of storedRequests) {
        await fetch(request);
    }
}
