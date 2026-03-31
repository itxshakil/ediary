function trackShare() {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event: 'floating_share_clicked' });
}

export function initFloatingShare() {
    const shareButton = document.getElementById('floating-share-btn');

    if (!shareButton) {
        return;
    }

    shareButton.addEventListener('click', async () => {
        trackShare();

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
        alert('App link copied to clipboard! Share it with your friends.');
    });
}
