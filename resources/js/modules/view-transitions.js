export function initViewTransitions() {
    if (!('startViewTransition' in document)) {
        return;
    }

    document.addEventListener('click', (event) => {
        const anchor = event.target.closest('a[href]');

        if (!anchor) {
            return;
        }

        const url = new URL(anchor.href, window.location.href);

        if (url.origin !== window.location.origin || anchor.target === '_blank') {
            return;
        }

        event.preventDefault();
        document.startViewTransition(() => {
            window.location.href = anchor.href;
        });
    });
}
