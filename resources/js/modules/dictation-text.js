/**
 * Insert a dictated phrase into a text value at the caret, replacing any selection
 * and adding a separating space only when needed.
 *
 * @returns {{ value: string, caret: number }}
 */
export function insertTranscript(value, selectionStart, selectionEnd, transcript) {
    const text = transcript.trim();

    if (text === '') {
        return { value, caret: selectionEnd };
    }

    const before = value.slice(0, selectionStart);
    const after = value.slice(selectionEnd);
    const needsSpace = before !== '' && !/\s$/.test(before);
    const inserted = (needsSpace ? ' ' : '') + text;

    return { value: before + inserted + after, caret: before.length + inserted.length };
}
