import assert from 'node:assert/strict';
import { beforeEach, test } from 'node:test';

import { initPasswordToggles } from '../../resources/js/modules/password-toggle.js';

let clickListener;
let input;
let button;

const icon = () => ({ hidden: false, classList: { toggle(name, force) { this.owner.hidden = force; } } });

beforeEach(() => {
    input = { type: 'password' };
    const show = icon();
    const hide = icon();
    show.classList.owner = show;
    hide.classList.owner = hide;
    const attributes = {};
    button = {
        dataset: { passwordToggle: 'password' },
        attributes,
        icons: { show, hide },
        setAttribute: (name, value) => (attributes[name] = value),
        querySelector: (selector) => (selector.includes('show') ? show : hide),
    };
    globalThis.document = {
        addEventListener: (type, listener) => type === 'click' && (clickListener = listener),
        getElementById: (id) => (id === 'password' ? input : null),
    };
    initPasswordToggles();
});

const click = (target) => clickListener({ target: { closest: () => target } });

test('reveals the password and updates the button for screen readers', () => {
    click(button);

    assert.equal(input.type, 'text');
    assert.equal(button.attributes['aria-pressed'], 'true');
    assert.equal(button.attributes['aria-label'], 'Hide password');
    assert.equal(button.icons.show.hidden, true);
    assert.equal(button.icons.hide.hidden, false);
});

test('a second click hides it again', () => {
    click(button);
    click(button);

    assert.equal(input.type, 'password');
    assert.equal(button.attributes['aria-pressed'], 'false');
    assert.equal(button.attributes['aria-label'], 'Show password');
});

test('clicks elsewhere change nothing', () => {
    click(null);

    assert.equal(input.type, 'password');
});
