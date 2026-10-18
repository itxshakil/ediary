const TYPES = ['success', 'error', 'warning', 'info'];
const MAX_VISIBLE = 3;
const DURATION = { success: 4000, info: 5000, warning: 7000, error: 8000 };

function dismiss(toast) {
    if (toast.classList.contains('toast--leaving')) {
        return;
    }

    clearTimeout(toast.dismissTimer);
    toast.classList.add('toast--leaving');

    const remove = () => toast.remove();
    toast.addEventListener('transitionend', remove, { once: true });
    // Reduced motion makes the transition instant, and some browsers then skip transitionend.
    setTimeout(remove, 400);
}

function schedule(toast) {
    const type = toast.dataset.toastType;
    const start = () => {
        clearTimeout(toast.dismissTimer);
        toast.dismissTimer = setTimeout(() => dismiss(toast), DURATION[type] ?? DURATION.info);
    };
    const pause = () => clearTimeout(toast.dismissTimer);

    // Give people time to read: hold while hovered or focused.
    toast.addEventListener('mouseenter', pause);
    toast.addEventListener('mouseleave', start);
    toast.addEventListener('focusin', pause);
    toast.addEventListener('focusout', start);
    toast.querySelector('[data-toast-close]').addEventListener('click', () => dismiss(toast));

    start();
}

export function toast({ type = 'info', title = '', message = '' } = {}) {
    const region = document.getElementById('toasts');
    const template = document.getElementById('toast-template');

    if (!region || !template) {
        console.info(`[${type}] ${title} ${message}`.trim());
        return;
    }

    const safeType = TYPES.includes(type) ? type : 'info';
    const element = template.content.firstElementChild.cloneNode(true);

    element.dataset.toastType = safeType;
    element.setAttribute('role', safeType === 'error' ? 'alert' : 'status');

    const titleEl = element.querySelector('[data-toast-title]');
    titleEl.textContent = title;
    titleEl.hidden = !title;
    element.querySelector('[data-toast-message]').textContent = message;

    region.append(element);
    schedule(element);

    const visible = [...region.querySelectorAll('[data-toast]:not(.toast--leaving)')];
    visible.slice(0, Math.max(0, visible.length - MAX_VISIBLE)).forEach(dismiss);

    return element;
}

export function initToasts() {
    // Inline Blade scripts reach toasts through window.toast.
    window.toast = toast;
    document.querySelectorAll('#toasts [data-toast]').forEach(schedule);
}
