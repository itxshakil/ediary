// Radios can't be unchecked by clicking them again, but mood is optional, so allow it.
export function initMoodPickers() {
    document.querySelectorAll('[data-mood-picker]').forEach((picker) => {
        let checkedBeforeClick = null;

        picker.addEventListener('pointerdown', (event) => {
            const label = event.target.closest('label');
            checkedBeforeClick = label?.querySelector('input:checked') ?? null;
        });

        // Clicking the label first fires a click on the label, then one on the radio; act on the radio's.
        picker.addEventListener('click', (event) => {
            const input = event.target.closest('input[type="radio"]');
            if (!input) return;

            if (input === checkedBeforeClick) {
                input.checked = false;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
            checkedBeforeClick = null;
        });
    });
}
