import assert from 'node:assert/strict';
import { test } from 'node:test';

import { insertTranscript } from '../../resources/js/modules/dictation-text.js';

test('inserts into an empty field without extra spacing', () => {
    assert.deepEqual(insertTranscript('', 0, 0, 'hello world'), { value: 'hello world', caret: 11 });
});

test('adds a space when appending after a word', () => {
    assert.deepEqual(insertTranscript('Today', 5, 5, 'was long'), { value: 'Today was long', caret: 14 });
});

test('does not double up spaces or break after a newline', () => {
    assert.deepEqual(insertTranscript('Today ', 6, 6, 'was long'), { value: 'Today was long', caret: 14 });
    assert.deepEqual(insertTranscript('Line one\n', 9, 9, 'line two'), { value: 'Line one\nline two', caret: 17 });
});

test('inserts at the caret and keeps the text after it', () => {
    assert.deepEqual(insertTranscript('I went home', 6, 6, 'to the lab and'), {
        value: 'I went to the lab and home',
        caret: 21,
    });
});

test('replaces a selection', () => {
    assert.deepEqual(insertTranscript('I felt sad today', 7, 10, 'calm'), { value: 'I felt calm today', caret: 11 });
});

test('ignores blank transcripts', () => {
    assert.deepEqual(insertTranscript('Keep me', 7, 7, '   '), { value: 'Keep me', caret: 7 });
});
