/** Buttons with data-password-toggle="<input id>" switch that field between hidden and visible text. */
export function initPasswordToggles() {
    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-password-toggle]');
        const input = button && document.getElementById(button.dataset.passwordToggle);
        if (!input) return;

        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(visible));
        button.setAttribute('aria-label', visible ? 'Hide password' : 'Show password');
        button.querySelector('[data-icon="show"]')?.classList.toggle('hidden', visible);
        button.querySelector('[data-icon="hide"]')?.classList.toggle('hidden', !visible);
    });
}
