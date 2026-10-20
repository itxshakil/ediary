/** Sends an event to GTM's dataLayer; GTM decides which events reach GA. */
export function track(event, params = {}) {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event, ...params });
}

/** Elements with data-track="event_name" report a click without page-specific code. */
export function initClickTracking() {
    document.addEventListener('click', (event) => {
        const target = event.target.closest('[data-track]');
        if (target) track(target.dataset.track);
    });
}
