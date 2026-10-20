import { track } from './analytics';

export function initFloatingShare() {
    document.querySelectorAll('[data-share-app]').forEach((shareButton) => shareButton.addEventListener('click', async () => {
        track('floating_share_clicked');

        if (navigator.share) {
            try {
                await navigator.share({
                    title: 'Ediary - Your Private Digital Journal',
                    text: 'Start your private journey with Ediary! Securely document your life for free.',
                    url: window.location.origin,
                });

                return;
            } catch {
                // Fall through to clipboard fallback when share is cancelled or unsupported.
            }
        }

        await navigator.clipboard.writeText(window.location.origin);
        window.toast?.({ type: 'success', message: 'App link copied. Share it with your friends!' });
    }));
}
