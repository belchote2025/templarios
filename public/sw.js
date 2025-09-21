const CACHE_NAME = 'mariscales-cache-v2';
const URLS_TO_CACHE = [
  '/prueba-php/public/',
  '/prueba-php/public/noticias',
  '/prueba-php/public/contacto',
  '/prueba-php/public/assets/css/style.css',
  '/prueba-php/public/assets/css/animations.css',
  '/prueba-php/public/offline.html',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
  'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(URLS_TO_CACHE))
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(keys.map((key) => (key !== CACHE_NAME ? caches.delete(key) : null)))
    )
  );
});

self.addEventListener('fetch', (event) => {
  const req = event.request;
  event.respondWith(
    fetch(req)
      .then((res) => {
        const clone = res.clone();
        caches.open(CACHE_NAME).then((cache) => cache.put(req, clone));
        return res;
      })
      .catch(async () => {
        const cached = await caches.match(req);
        if (cached) return cached;
        // Fallback a offline.html para peticiones de navegación
        if (req.mode === 'navigate' || (req.method === 'GET' && req.headers.get('accept')?.includes('text/html'))) {
          return caches.match('/prueba-php/public/offline.html');
        }
        return new Response('Sin conexión', { status: 503, statusText: 'Offline' });
      })
  );
});
