import assert from 'node:assert/strict';
import { beforeEach, test } from 'node:test';

import { initClickTracking, track } from '../../resources/js/modules/analytics.js';

let clickListener;

beforeEach(() => {
    globalThis.window = {};
    globalThis.document = { addEventListener: (type, listener) => type === 'click' && (clickListener = listener) };
});

const clickOn = (dataset) => clickListener({ target: { closest: (selector) => (selector === '[data-track]' && dataset ? { dataset } : null) } });

test('pushes the event and its params to the dataLayer', () => {
    track('pwa_banner_shown', { variant: 'A' });

    assert.deepEqual(window.dataLayer, [{ event: 'pwa_banner_shown', variant: 'A' }]);
});

test('keeps events GTM already queued', () => {
    window.dataLayer = [{ event: 'gtm.js' }];

    track('login');

    assert.deepEqual(window.dataLayer, [{ event: 'gtm.js' }, { event: 'login' }]);
});

test('a click inside a data-track element reports that element', () => {
    initClickTracking();

    clickOn({ track: 'floating_add_clicked' });

    assert.deepEqual(window.dataLayer, [{ event: 'floating_add_clicked' }]);
});

test('other clicks report nothing', () => {
    initClickTracking();

    clickOn(null);

    assert.equal(window.dataLayer, undefined);
});
