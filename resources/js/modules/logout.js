// Cached pages can hold diary entries and the signed-in name, so they go before the next
// person picks up the device. The page clears Cache Storage itself: logout is a POST, which
// the service worker never sees.
const PAGE_CACHE_PREFIX = 'ediary-pages-';

export async function clearCachedPages() {
    if (!('caches' in window)) {
        return;
    }

    const keys = await caches.keys();
    await Promise.all(keys.filter((key) => key.startsWith(PAGE_CACHE_PREFIX)).map((key) => caches.delete(key)));
}

// Logout must never hang on a slow or broken Cache Storage.
export function clearCachedPagesWithin(ms) {
    return Promise.race([clearCachedPages().catch(() => {}), new Promise((resolve) => setTimeout(resolve, ms))]);
}

export function initLogoutForms() {
    document.addEventListener('submit', (event) => {
        const form = event.target.closest?.('form[data-logout]');
        if (!form) {
            return;
        }

        event.preventDefault();
        // form.submit() skips the submit event, so this doesn't loop.
        clearCachedPagesWithin(1000).then(() => form.submit());
    });
}
