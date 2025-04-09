self.addEventListener('install', event => {
    event.waitUntil(
        caches.open('homesavvy-cache').then(cache => {
            return cache.addAll([
                '/',
                '/index.php',
                '/index.html',
                '/css/index.css',
                '/js/main.js',
                '/assets/icons/homesavvy-192.png',
                '/assets/icons/homesavvy-512.png',
                '/auth/login.php',
                '/cliente/c-ver-soli-trabajo.php',
                '/admin/a-principal.php'
            ]);
        })
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        })
    );
});

