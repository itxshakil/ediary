/** Fills <input data-timezone> with the browser's timezone, so streaks and reminders follow the writer's day. */
export function initTimezoneFields() {
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    if (!timezone) return;

    document.querySelectorAll('input[data-timezone]').forEach((input) => (input.value = timezone));
}
