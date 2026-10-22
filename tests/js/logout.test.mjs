import assert from 'node:assert/strict';
import { beforeEach, test } from 'node:test';

import { clearCachedPages, clearCachedPagesWithin, initLogoutForms } from '../../resources/js/modules/logout.js';

let stored;
let submitListener;

beforeEach(() => {
    stored = new Set(['ediary-pages-v12', 'ediary-pages-v13', 'ediary-core-v1', 'ediary-static-abc123']);
    globalThis.caches = {
        keys: async () => [...stored],
        delete: async (key) => stored.delete(key),
    };
    globalThis.window = { caches: globalThis.caches };
    globalThis.document = { addEventListener: (type, listener) => type === 'submit' && (submitListener = listener) };
});

test('clears every page cache and keeps the asset caches', async () => {
    await clearCachedPages();

    assert.deepEqual([...stored], ['ediary-core-v1', 'ediary-static-abc123']);
});

test('does nothing where Cache Storage is missing', async () => {
    delete window.caches;

    await assert.doesNotReject(clearCachedPages());
});

test('gives up waiting when Cache Storage hangs', async () => {
    caches.keys = () => new Promise(() => {});

    await clearCachedPagesWithin(10);
});

test('submitting the logout form clears the page caches before it is sent', async () => {
    initLogoutForms();
    let prevented = false;
    const sent = new Promise((resolve) => {
        const form = { submit: () => resolve([...stored]) };
        submitListener({
            target: { closest: (selector) => (selector === 'form[data-logout]' ? form : null) },
            preventDefault: () => (prevented = true),
        });
    });

    assert.equal(prevented, true);
    assert.deepEqual(await sent, ['ediary-core-v1', 'ediary-static-abc123']);
});

test('other forms submit normally', () => {
    initLogoutForms();
    let prevented = false;

    submitListener({ target: { closest: () => null }, preventDefault: () => (prevented = true) });

    assert.equal(prevented, false);
});
