import assert from 'node:assert/strict';
import { test } from 'node:test';

import { applySessionTranscript, insertTranscript, latestFinalTranscript } from '../../resources/js/modules/dictation-text.js';

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

const result = (transcript, isFinal) => Object.assign([{ transcript }], { isFinal });

// Android Chrome re-sends the growing utterance, refined as it goes, as a new final result each time.
test('an Android utterance re-sent as it grows is written once', () => {
    const events = [
        [result('hello', true)],
        [result('hello', true), result('hello my naeme', true)],
        [result('hello', true), result('hello my naeme', true), result('hello my name', true)],
        [result('hello', true), result('hello my naeme', true), result('hello my name', true), result('hello my name is this', true)],
    ];
    let state = { value: 'Today', caret: 5, session: null };

    for (const results of events) {
        state = applySessionTranscript(state.value, state.session, state.caret, state.caret, latestFinalTranscript(results));
    }

    assert.equal(state.value, 'Today hello my name is this');
    assert.equal(state.caret, state.value.length);
});

test('a new session adds to the text instead of replacing the last one', () => {
    const first = applySessionTranscript('', null, 0, 0, 'hello my name is Shakil');
    const second = applySessionTranscript(first.value, null, first.caret, first.caret, 'I study biology');

    assert.equal(second.value, 'hello my name is Shakil I study biology');
});

test('text the user edited mid-session is kept and dictation goes in at the caret', () => {
    const first = applySessionTranscript('', null, 0, 0, 'hello');
    const edited = 'hullo';
    const next = applySessionTranscript(edited, first.session, 5, 5, 'hello my name');

    assert.equal(next.value, 'hullo hello my name');
});

test('the latest final result is used and interim ones are ignored', () => {
    assert.equal(latestFinalTranscript([result('hello', true), result('hello my', false)]), 'hello');
    assert.equal(latestFinalTranscript([result('hello', false)]), '');
});
