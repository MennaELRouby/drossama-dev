// Service Worker for Website - Updated with Enhanced Offline Page
const CACHE_NAME = 'site-v' + Date.now();
console.log('🚀 SW: Loading Service Worker v17 with enhanced offline page and dynamic data');
// We'll use inline HTML instead of external file
const OFFLINE_PAGE = null;

// Check if in development environment
const isDevelopment = () => {
  return self.location.hostname.includes('localhost') ||
    self.location.hostname.includes('.test') ||
    self.location.hostname.includes('127.0.0.1');
};

// Development-only logging
const devLog = (message) => {
  if (isDevelopment()) {
    console.log(message);
  }
};

// Essential files to cache
const STATIC_CACHE_URLS = [
  '/offline',  // Cache the offline page
];

// Install event - simplified installation
self.addEventListener('install', event => {
  console.log('🚀 SW: Installing Service Worker v17 with inline offline page...');

  event.waitUntil(
    Promise.all([
      // Open main cache and cache essential files
      caches.open(CACHE_NAME)
        .then((cache) => {
          console.log('✅ SW: Cache opened successfully');
          return Promise.all(
            STATIC_CACHE_URLS.map(url =>
              fetch(url)
                .then(response => {
                  if (response.ok) {
                    console.log('📱 SW: Caching essential file:', url);

                    // Check for Vary: * header before caching
                    const vary = response.headers.get('vary');
                    if (vary === '*') {
                      console.log('⚠️ SW: Skipping cache for', url, '(Vary: *)');
                      return Promise.resolve();
                    }

                    // Clone and cache with clean headers
                    return response.clone().text().then(body => {
                      const cleanResponse = new Response(body, {
                        status: response.status,
                        statusText: response.statusText,
                        headers: {
                          'Content-Type': response.headers.get('Content-Type') || 'text/html',
                          'Cache-Control': 'max-age=3600'
                        }
                      });
                      return cache.put(url, cleanResponse);
                    });
                  }
                })
                .catch(error => {
                  console.log('📱 SW: Could not cache:', url, error);
                })
            )
          );
        }),
      // Cache offline data
      caches.open('offline-data-cache')
        .then((cache) => {
          console.log('📱 SW: Caching offline data...');
          return fetch('/api/offline-data')
            .then(response => {
              if (response.ok) {
                console.log('📱 SW: Successfully fetched offline data');

                // Check for Vary: * header before caching
                const vary = response.headers.get('vary');
                if (vary === '*') {
                  console.log('⚠️ SW: Skipping offline data cache (Vary: *)');
                  return Promise.resolve();
                }

                // Clone and cache with clean headers
                return response.clone().text().then(body => {
                  const cleanResponse = new Response(body, {
                    status: response.status,
                    statusText: response.statusText,
                    headers: {
                      'Content-Type': 'application/json',
                      'Cache-Control': 'max-age=3600'
                    }
                  });
                  return cache.put('/api/offline-data', cleanResponse);
                });
              } else {
                console.log('📱 SW: Failed to fetch offline data, status:', response.status);
              }
            })
            .catch(error => {
              console.log('📱 SW: Could not fetch offline data:', error);
            });
        })
    ])
      .then(() => {
        console.log('✅ SW: Installation complete - offline page is inline with dynamic data');
        return self.skipWaiting();
      })
      .catch(error => {
        console.error('❌ SW: Install failed', error);
      })
  );
});

// Activate event - clean old caches and take control
self.addEventListener('activate', event => {
  devLog('🔄 SW: Activating...');

  event.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            if (cacheName !== CACHE_NAME && cacheName !== 'offline-data-cache') {
              devLog('🗑️ SW: Deleting old cache:', cacheName);
              return caches.delete(cacheName);
            }
          })
        );
      })
      .then(() => {
        devLog('✅ SW: Activated and controlling all pages');
        return self.clients.claim();
      })
  );
});

// Periodic update of offline data
self.addEventListener('message', event => {
  if (event.data && event.data.type === 'UPDATE_OFFLINE_DATA') {
    updateOfflineData();
  }
});

// Function to update offline data
async function updateOfflineData() {
  try {
    console.log('📱 SW: Updating offline data...');
    const response = await fetch('/api/offline-data');
    if (response.ok) {
      const cache = await caches.open('offline-data-cache');
      await cache.put('/api/offline-data', response.clone());
      console.log('📱 SW: Offline data updated successfully');
    }
  } catch (error) {
    console.log('📱 SW: Failed to update offline data:', error);
  }
}

// Fetch event - handle all network requests
self.addEventListener('fetch', event => {
  const { request } = event;

  // Skip non-GET requests
  if (request.method !== 'GET') return;

  // Skip external requests
  if (!request.url.startsWith(self.location.origin)) return;

  // Skip service worker file itself
  if (request.url.includes('/sw.js')) return;

  devLog('🔍 SW: Intercepting request: ' + new URL(request.url).pathname);

  event.respondWith(handleFetch(request));
});

// Main fetch handler
async function handleFetch(request) {
  const url = new URL(request.url);

  // For page requests, use Network First strategy for fresh data
  if (isPageRequest(request)) {
    devLog('🌐 SW: Page request for: ' + url.pathname);

    // Try network first to get fresh data
    try {
      devLog('🌐 SW: Fetching fresh page from network: ' + url.pathname);

      // Set a shorter timeout for network requests to fail fast when offline
      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), 3000); // 3 second timeout

      const networkResponse = await fetch(request, {
        signal: controller.signal
      });

      clearTimeout(timeoutId);

      if (networkResponse.ok) {
        devLog('✅ SW: Fresh page fetched, updating cache...');
        await cacheResponse(request, networkResponse.clone());
        return networkResponse;
      } else {
        devLog('⚠️ SW: Server error (status: ' + networkResponse.status + ')');

        // Handle different error types
        if (networkResponse.status >= 500 && networkResponse.status < 600) {
          // Server errors (500, 502, 503, etc.) - show the actual error
          devLog('🚨 SW: Server error detected, showing Laravel error page');
          return networkResponse;
        } else if (networkResponse.status === 404) {
          // 404 errors - try cache first, then show error
          devLog('🔍 SW: 404 error, checking cache first');
          const cachedResponse = await caches.match(request);
          if (cachedResponse) {
            devLog('✅ SW: Serving cached page for 404: ' + url.pathname);
            return cachedResponse;
          } else {
            devLog('📄 SW: No cached page, showing 404 error');
            return networkResponse;
          }
        } else {
          // Other client errors (401, 403, etc.) - show the error
          devLog('🚫 SW: Client error, showing error page');
          return networkResponse;
        }
      }
    } catch (error) {
      console.log('❌ SW: Network completely failed: ' + error.message);
      console.log('🔍 SW: Checking cache for: ' + url.pathname);

      // Try to serve from cache first before showing offline page
      const cachedResponse = await caches.match(request);
      if (cachedResponse) {
        console.log('✅ SW: Serving cached page while offline: ' + url.pathname);
        return cachedResponse;
      } else {
        console.log('📱 SW: No cached page found, showing offline page');
        console.log('🎯 SW: Request URL was: ' + request.url);
        console.log('🚀 SW: About to serve offline page');

        // Try to get offline page from cache first
        const cachedOfflinePage = await caches.match('/offline');
        if (cachedOfflinePage) {
          console.log('✅ SW: Serving cached offline page');
          return cachedOfflinePage;
        }

        // If not in cache, try to fetch it
        try {
          const offlineResponse = await fetch('/offline');
          if (offlineResponse.ok) {
            console.log('✅ SW: Successfully fetched offline page');
            return offlineResponse;
          } else {
            console.log('⚠️ SW: Offline page fetch failed, status:', offlineResponse.status);
            return getOfflinePage();
          }
        } catch (error) {
          console.log('❌ SW: Could not fetch offline page:', error);
          return getOfflinePage();
        }
      }
    }
  }

  // For other resources (CSS, JS, images, etc.)
  try {
    // Try cache first
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      devLog('📦 SW: Serving from cache:', url.pathname);
      return cachedResponse;
    }

    // Try network
    devLog('🌐 SW: Fetching from network:', url.pathname);
    const networkResponse = await fetch(request);

    // Cache successful responses
    if (networkResponse.ok) {
      await cacheResponse(request, networkResponse.clone());
    }

    return networkResponse;

  } catch (error) {
    devLog('❌ SW: Network failed for resource:', url.pathname);

    // Return error for resources
    return new Response('Offline', {
      status: 503,
      statusText: 'Service Unavailable'
    });
  }
}

// Cache successful responses
async function cacheResponse(request, response) {
  try {
    const cache = await caches.open(CACHE_NAME);

    // For HTML pages, ALWAYS cache regardless of headers (force caching)
    if (isPageRequest(request)) {
      // Read the response body
      const responseBody = await response.clone().text();

      // Create a clean response without problematic headers
      const cleanResponse = new Response(responseBody, {
        status: response.status,
        statusText: response.statusText,
        headers: {
          'Content-Type': 'text/html; charset=utf-8',
          'Cache-Control': 'max-age=3600' // Cache for 1 hour
        }
      });

      await cache.put(request, cleanResponse);
      devLog('💾 SW: Cached page (forced):', request.url);
      return;
    }

    // For other resources, check headers
    const vary = response.headers.get('vary');
    if (vary === '*') {
      devLog('⚠️ SW: Skipping resource cache due to Vary: *');
      return;
    }

    const cacheControl = response.headers.get('cache-control');
    if (cacheControl?.includes('no-store')) {
      devLog('⚠️ SW: Skipping resource cache due to no-store');
      return;
    }

    await cache.put(request, response);
    devLog('💾 SW: Cached:', request.url);

  } catch (error) {
    devLog('⚠️ SW: Cache failed:', error.message);
  }
}

// Check if request is for a page
function isPageRequest(request) {
  // Primary check: navigation requests
  if (request.mode === 'navigate') {
    return true;
  }

  // Secondary check: document destination
  if (request.destination === 'document') {
    return true;
  }

  // Check Accept header for HTML
  const acceptHeader = request.headers.get('accept');
  if (acceptHeader && acceptHeader.includes('text/html')) {
    return true;
  }

  // Check URL patterns for pages (no file extension or common page paths)
  const url = new URL(request.url);
  const pathname = url.pathname;

  // Skip API endpoints and assets
  if (pathname.includes('/api/') ||
    pathname.includes('/assets/') ||
    pathname.includes('/_debugbar/') ||
    pathname.includes('/sw.js')) {
    return false;
  }

  // Check for file extensions (not a page if it has common file extensions)
  const fileExtensions = /\.(js|css|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot|json|xml|txt|pdf|webp|avif|bmp)$/i;
  if (fileExtensions.test(pathname)) {
    return false;
  }

  // If it's a GET request and doesn't match exclusions, treat as page
  return request.method === 'GET';
}

// Get offline page - serve inline HTML directly
async function getOfflinePage() {
  console.log('🎉 SW: *** ENHANCED OFFLINE PAGE FUNCTION CALLED ***');
  console.log('📱 SW: User is offline, serving enhanced offline page with contact info...');

  // Try to get dynamic data from cache first
  let offlineData = null;
  try {
    const cache = await caches.open('offline-data-cache');
    const response = await cache.match('/api/offline-data');
    if (response) {
      offlineData = await response.json();
      console.log('📱 SW: Using cached offline data:', offlineData);
      console.log('📱 SW: Phones count:', offlineData.phones ? offlineData.phones.length : 0);
    } else {
      console.log('📱 SW: No cached offline data found, trying to fetch fresh data...');
      // Try to fetch fresh data if online
      if (navigator.onLine) {
        try {
          const freshResponse = await fetch('/api/offline-data');
          if (freshResponse.ok) {
            offlineData = await freshResponse.json();
            // Cache the fresh data
            await cache.put('/api/offline-data', freshResponse.clone());
            console.log('📱 SW: Fetched and cached fresh offline data:', offlineData);
            console.log('📱 SW: Fresh phones count:', offlineData.phones ? offlineData.phones.length : 0);
          } else {
            console.log('📱 SW: Fresh data fetch failed, status:', freshResponse.status);
          }
        } catch (fetchError) {
          console.log('📱 SW: Could not fetch fresh data:', fetchError);
        }
      } else {
        console.log('📱 SW: Offline, cannot fetch fresh data');
      }
    }
  } catch (error) {
    console.log('📱 SW: Could not get offline data:', error);
  }

  console.log('📱 SW: Final offlineData:', offlineData);

  // Fallback offline response - enhanced version matching the Laravel page

}

// Handle messages from main thread
self.addEventListener('message', event => {
  if (event.data?.type === 'SKIP_WAITING') {
    self.skipWaiting();
  } else if (event.data?.type === 'REFRESH_CACHE') {
    // Force refresh specific page cache
    const url = event.data.url;
    refreshPageCache(url);
  } else if (event.data?.type === 'CLAIM_CLIENTS') {
    // Force claim all clients immediately
    devLog('🔄 SW: Claiming all clients...');
    self.clients.claim();
  }
});

// Function to refresh page cache
async function refreshPageCache(url) {
  try {
    devLog('🔄 SW: Refreshing cache for:', url);
    const request = new Request(url);
    const response = await fetch(request);

    if (response.ok) {
      await cacheResponse(request, response.clone());
      devLog('✅ SW: Cache refreshed for:', url);
    }
  } catch (error) {
    devLog('⚠️ SW: Failed to refresh cache:', error.message);
  }
}

// Periodic cache refresh (every 30 minutes)
setInterval(async () => {
  try {
    const cache = await caches.open(CACHE_NAME);
    const requests = await cache.keys();

    // Only refresh HTML pages, not resources
    const pageRequests = requests.filter(req =>
      req.url.includes('/en') ||
      req.url.includes('/ar') ||
      req.url.endsWith('/')
    );

    devLog(`🔄 SW: Background refresh for ${pageRequests.length} pages`);

    // Refresh up to 5 pages to avoid overwhelming
    for (const request of pageRequests.slice(0, 5)) {
      try {
        const response = await fetch(request);
        if (response.ok) {
          await cacheResponse(request, response.clone());
          devLog('🔄 SW: Background updated:', request.url);
        }
      } catch (error) {
        // Silently fail for background updates
      }
    }
  } catch (error) {
    devLog('⚠️ SW: Background refresh failed:', error.message);
  }
}, 30 * 60 * 1000); // 30 minutes

devLog('✅ SW: Script loaded');
