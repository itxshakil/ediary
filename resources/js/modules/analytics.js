/** Sends an event to Google Analytics; gtag() is defined in the layout head. */
export function track(event, params = {}) {
    window.gtag?.('event', event, params);
}

/** Elements with data-track="event_name" report a click without page-specific code. */
export function initClickTracking() {
    document.addEventListener('click', (event) => {
        const target = event.target.closest('[data-track]');
        if (target) track(target.dataset.track);
    });
}
