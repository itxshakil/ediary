import assert from 'node:assert/strict';
import { beforeEach, test } from 'node:test';

import { initClickTracking, track } from '../../resources/js/modules/analytics.js';

let clickListener;
let calls;

beforeEach(() => {
    calls = [];
    globalThis.window = { gtag: (...args) => calls.push(args) };
    globalThis.document = { addEventListener: (type, listener) => type === 'click' && (clickListener = listener) };
});

const clickOn = (dataset) => clickListener({ target: { closest: (selector) => (selector === '[data-track]' && dataset ? { dataset } : null) } });

test('sends the event and its params to Google Analytics', () => {
    track('pwa_banner_shown', { variant: 'A' });

    assert.deepEqual(calls, [['event', 'pwa_banner_shown', { variant: 'A' }]]);
});

test('does nothing when gtag is missing', () => {
    delete window.gtag;

    assert.doesNotThrow(() => track('login'));
});

test('a click inside a data-track element reports that element', () => {
    initClickTracking();

    clickOn({ track: 'floating_add_clicked' });

    assert.deepEqual(calls, [['event', 'floating_add_clicked', {}]]);
});

test('other clicks report nothing', () => {
    initClickTracking();

    clickOn(null);

    assert.deepEqual(calls, []);
});
