import { offlineStore } from './offline-store';
import { toast } from './toast';

const DRAFT_KEYS = { title: 'diary_draft_title', entry: 'diary_draft_entry' };

const storage = {
    get: (key) => {
        try {
            return localStorage.getItem(key);
        } catch {
            return null;
        }
    },
    set: (key, value) => {
        if (value === '') {
            storage.remove(key);
            return;
        }

        try {
            localStorage.setItem(key, value);
        } catch {
            // Private mode or blocked storage: drafts are a convenience, so carry on without them.
        }
    },
    remove: (key) => {
        try {
            localStorage.removeItem(key);
        } catch {
            // As above.
        }
    },
};

const clearDraft = () => Object.values(DRAFT_KEYS).forEach(storage.remove);

function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = `${Math.max(textarea.scrollHeight, 120)}px`;
}

/**
 * Behaviour shared by every <form data-entry-form>: draft autosave, offline saving,
 * Ctrl/Cmd+Enter to submit and a growing entry field. Forms react to `entry-form:reset`
 * for their own extra UI (tags, counters).
 */
function setupEntryForm(form) {
    const title = form.elements.namedItem('title');
    const entry = form.elements.namedItem('entry');
    const offlineNote = form.querySelector('[data-offline-note]');
    let dirty = false;

    entry.addEventListener('input', () => {
        storage.set(DRAFT_KEYS.entry, entry.value);
        dirty = entry.value.trim() !== '';
        autoResize(entry);
    });
    title?.addEventListener('input', () => storage.set(DRAFT_KEYS.title, title.value));

    if (!entry.value && !title?.value) {
        entry.value = storage.get(DRAFT_KEYS.entry) ?? '';
        if (title) title.value = storage.get(DRAFT_KEYS.title) ?? '';
    }
    // Let the form's own listeners (counters, sizing) see restored or server-filled text.
    entry.dispatchEvent(new Event('input'));

    entry.addEventListener('keydown', (event) => {
        if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
            event.preventDefault();
            form.requestSubmit();
        }
    });

    const syncOfflineNote = () => offlineNote?.classList.toggle('hidden', navigator.onLine);
    window.addEventListener('online', syncOfflineNote);
    window.addEventListener('offline', syncOfflineNote);
    syncOfflineNote();

    if (form.hasAttribute('data-warn-unsaved')) {
        window.addEventListener('beforeunload', (event) => {
            if (dirty) event.preventDefault();
        });
    }

    form.addEventListener('submit', async (event) => {
        if (navigator.onLine) {
            dirty = false;
            clearDraft();
            return;
        }

        event.preventDefault();
        const fields = Object.fromEntries(new FormData(form));

        try {
            await offlineStore.save({
                title: fields.title || null,
                entry: fields.entry.trim(),
                mood: fields.mood || null,
                tags: fields.tags ?? '',
                privacy: fields.privacy || null,
            });
        } catch (error) {
            console.error('Failed to save offline:', error);
            toast({ type: 'error', title: 'Could not save offline', message: 'Your text is still in the form. Please try again.' });
            return;
        }

        // reset() also clears the browser's "user edited" state, so the emptied required field isn't
        // flagged :user-invalid; then clear values the server pre-filled (old input) as defaults.
        form.reset();
        form.querySelectorAll('input[type="text"], textarea').forEach((field) => (field.value = ''));
        autoResize(entry);
        dirty = false;
        clearDraft();
        form.dispatchEvent(new CustomEvent('entry-form:reset'));
    });
}

export function initEntryForms() {
    document.querySelectorAll('form[data-entry-form]').forEach(setupEntryForm);
}
