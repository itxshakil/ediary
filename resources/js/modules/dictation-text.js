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

/**
 * Put a recognition session's latest transcript into a text value. Text this session already
 * inserted is replaced rather than appended to, so a recognizer that re-sends the whole utterance
 * as it refines it does not repeat words. When the user has edited that text since, the
 * transcript goes in at the caret instead.
 *
 * @param {{ start: number, end: number, text: string } | null} session What this session inserted so far.
 * @returns {{ value: string, caret: number, session: { start: number, end: number, text: string } }}
 */
export function applySessionTranscript(value, session, selectionStart, selectionEnd, transcript) {
    const intact = session !== null && value.slice(session.start, session.end) === session.text;
    const [start, end] = intact ? [session.start, session.end] : [selectionStart, selectionEnd];
    const result = insertTranscript(value, start, end, transcript);

    return { ...result, session: { start, end: result.caret, text: result.value.slice(start, result.caret) } };
}

/**
 * The transcript of the most recent final result, or '' when nothing is final yet.
 *
 * @param {ArrayLike<ArrayLike<{ transcript: string }> & { isFinal: boolean }>} results
 */
export function latestFinalTranscript(results) {
    for (let i = results.length - 1; i >= 0; i--) {
        if (results[i].isFinal) {
            return results[i][0].transcript;
        }
    }

    return '';
}
