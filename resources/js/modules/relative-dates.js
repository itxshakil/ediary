const DIVISIONS = [
    { amount: 60, name: 'second' },
    { amount: 60, name: 'minute' },
    { amount: 24, name: 'hour' },
    { amount: 7, name: 'day' },
    { amount: 4.34524, name: 'week' },
    { amount: 12, name: 'month' },
    { amount: Number.POSITIVE_INFINITY, name: 'year' },
];

function formatRelative(date, locale, relativeFormat) {
    const seconds = Math.floor((Date.now() - date.getTime()) / 1000);

    if (seconds < 45) {
        return locale.startsWith('en') ? 'Just now' : null;
    }

    let duration = seconds;

    for (const division of DIVISIONS) {
        if (Math.abs(duration) < division.amount) {
            return relativeFormat.format(-Math.round(duration), division.name);
        }

        duration /= division.amount;
    }

    return null;
}

/**
 * Localises every [data-time] element to the reader's language and timezone: a `.js-date`
 * (the element itself or a child) gets a relative time, `[data-date-part]` children get the
 * day, month or weekday, and the element gets the full date as its tooltip.
 */
export function initRelativeDates() {
    const elements = document.querySelectorAll('[data-time]');
    if (elements.length === 0) return;

    // Build the formatters once; constructing Intl formatters per element is comparatively slow.
    const locale = navigator.language;
    const relativeFormat = new Intl.RelativeTimeFormat(locale, { numeric: 'auto' });
    const absoluteFormat = new Intl.DateTimeFormat(locale, { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit' });
    const shortDateFormat = new Intl.DateTimeFormat(locale, { year: 'numeric', month: 'short', day: 'numeric' });
    const partFormats = {
        day: new Intl.DateTimeFormat(locale, { day: 'numeric' }),
        month: new Intl.DateTimeFormat(locale, { month: 'short' }),
        weekday: new Intl.DateTimeFormat(locale, { weekday: 'short' }),
    };

    elements.forEach((element) => {
        const date = new Date(element.dataset.time);

        if (Number.isNaN(date.getTime())) {
            return;
        }

        const target = element.matches('.js-date') ? element : element.querySelector('.js-date');
        if (target) {
            target.textContent = formatRelative(date, locale, relativeFormat) ?? shortDateFormat.format(date);
        }

        element.querySelectorAll('[data-date-part]').forEach((part) => {
            const format = partFormats[part.dataset.datePart];
            if (format) {
                part.textContent = format.format(date);
            }
        });

        element.title = absoluteFormat.format(date);
        element.setAttribute('datetime', date.toISOString());
    });
}
