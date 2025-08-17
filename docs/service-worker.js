self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open('stockly-cache-v1').then((cache) => {
      return cache.addAll([
        './',
        './index.html',
        './manifest.webmanifest',
        './icons/icon(1).png',
        './icons/maskable.icon.png'
      ]);
    })
  );
});

self.addEventListener('fetch', (event) => {
  // Implement a network-first strategy with cache fallback
  event.respondWith(
    fetch(event.request)
      .then((response) => {
        // For successful responses, update the cache
        if (response.ok) {
          const responseClone = response.clone();
          caches.open('stockly-cache-v1').then((cache) => {
            cache.put(event.request, responseClone);
          });
        }
        return response;
      })
      .catch((error) => {
        // If network request fails, try to get from cache
        console.log('Network request failed, falling back to cache:', error);
        return response;
      })
      .catch(async (error) => {
        // If network request fails, try to get from cache
        console.log('Network request failed, falling back to cache:', error);
        const cachedResponse = await caches.match(event.request);
        if (cachedResponse) {
          return cachedResponse;
        }
        // If not in cache, return a basic response based on request type
        if (event.request && event.request.mode === 'navigate') {
          const indexResponse = await caches.match('./index.html');
          if (indexResponse) {
            return indexResponse;
          }
        }
        return new Response('', { status: 404, statusText: 'Not Found' });
      })
  );
});
