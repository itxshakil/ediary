import assert from 'node:assert/strict';
import { beforeEach, test } from 'node:test';

import { initWritingPrompts } from '../../resources/js/modules/writing-prompt.js';

let box;
let fields;
let handlers;

beforeEach(() => {
    handlers = {};
    fields = { title: { value: '', dispatchEvent() {} }, entry: { focused: false, focus() { this.focused = true; } } };
    const text = { textContent: 'First' };
    const button = (name) => ({ addEventListener: (type, fn) => (handlers[name] = fn) });
    box = {
        dataset: { prompts: JSON.stringify(['First', 'Second']), index: '0', titleField: 'title', entryField: 'entry' },
        text,
        querySelector: (selector) => ({ '[data-prompt-text]': text, '[data-prompt-next]': button('next'), '[data-prompt-use]': button('use') })[selector],
        closest: () => ({ elements: { namedItem: (name) => fields[name] } }),
    };
    globalThis.window = {};
    globalThis.document = { querySelectorAll: () => [box] };
    initWritingPrompts();
});

test('"Another" cycles through the prompts and wraps around', () => {
    handlers.next();
    assert.equal(box.text.textContent, 'Second');
    handlers.next();
    assert.equal(box.text.textContent, 'First');
});

test('using a prompt fills an empty title, focuses the entry and reports it', () => {
    handlers.next();
    handlers.use();

    assert.equal(fields.title.value, 'Second');
    assert.equal(fields.entry.focused, true);
    assert.deepEqual(window.dataLayer, [{ event: 'writing_prompt_used' }]);
});

test('a title the writer already typed is kept', () => {
    fields.title.value = 'My own title';
    handlers.use();

    assert.equal(fields.title.value, 'My own title');
    assert.equal(fields.entry.focused, true);
});
