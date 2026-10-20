import { track } from './analytics.js';

/**
 * [data-writing-prompt]: "Use this prompt" puts the prompt in the title (unless one is written)
 * and moves to the entry; "Another" cycles through the list.
 */
export function initWritingPrompts() {
    document.querySelectorAll('[data-writing-prompt]').forEach((box) => {
        const prompts = JSON.parse(box.dataset.prompts);
        const text = box.querySelector('[data-prompt-text]');
        const form = box.closest('form');
        let index = Number(box.dataset.index) || 0;

        box.querySelector('[data-prompt-next]')?.addEventListener('click', () => {
            index = (index + 1) % prompts.length;
            text.textContent = prompts[index];
        });

        box.querySelector('[data-prompt-use]')?.addEventListener('click', () => {
            const title = form?.elements.namedItem(box.dataset.titleField);
            const entry = form?.elements.namedItem(box.dataset.entryField);

            if (title && title.value.trim() === '') {
                title.value = prompts[index];
                title.dispatchEvent(new Event('input'));
            }
            entry?.focus();
            track('writing_prompt_used');
        });
    });
}
