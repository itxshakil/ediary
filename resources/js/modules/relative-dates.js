function formatRelative(date, locale) {
    const seconds = Math.floor((Date.now() - date.getTime()) / 1000);

    if (seconds < 45) {
        return locale.startsWith('en') ? 'Just now' : null;
    }

    const formatter = new Intl.RelativeTimeFormat(locale, { numeric: 'auto' });
    const divisions = [
        { amount: 60, name: 'second' },
        { amount: 60, name: 'minute' },
        { amount: 24, name: 'hour' },
        { amount: 7, name: 'day' },
        { amount: 4.34524, name: 'week' },
        { amount: 12, name: 'month' },
        { amount: Number.POSITIVE_INFINITY, name: 'year' },
    ];

    let duration = seconds;

    for (const division of divisions) {
        if (Math.abs(duration) < division.amount) {
            return formatter.format(-Math.round(duration), division.name);
        }

        duration /= division.amount;
    }

    return null;
}

export function initRelativeDates() {
    document.querySelectorAll('[data-time]').forEach((element) => {
        const iso = element.dataset.time;

        if (!iso) {
            return;
        }

        const date = new Date(iso);

        if (Number.isNaN(date.getTime())) {
            return;
        }

        const locale = navigator.language;
        const relative = formatRelative(date, locale);
        const absolute = date.toLocaleString(locale, {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
        });

        const target = element.querySelector('.js-date');
        if (target) {
            target.textContent = relative ?? absolute.split(',')[0];
        }

        element.title = absolute;
        element.setAttribute('datetime', date.toISOString());
    });
}
