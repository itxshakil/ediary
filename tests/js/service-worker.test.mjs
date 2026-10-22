import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { beforeEach, test } from 'node:test';
import vm from 'node:vm';

// The worker is a classic script, so it runs here in a sandbox with fake caches and fetch.
const source = readFileSync(new URL('../../public/service-worker.js', import.meta.url), 'utf8');

let pages;
let fetchListener;

beforeEach(() => {
    pages = new Map();
    const pageCache = {
        put: async (request, response) => pages.set(new URL(request.url ?? request, 'https://ediary.test').pathname, response),
        match: async (request) => pages.get(new URL(request.url ?? request, 'https://ediary.test').pathname),
    };
    const self = {
        addEventListener: (type, listener) => type === 'fetch' && (fetchListener = listener),
    };

    vm.runInNewContext(source, {
        self,
        importScripts: () => {},
        console,
        URL,
        Headers,
        Response,
        caches: { open: async () => pageCache, match: async () => undefined },
        fetch: async () => new Response('<p>page</p>', { status: 200 }),
    });
});

async function visit(path) {
    let responded;
    fetchListener({
        request: { method: 'GET', mode: 'navigate', url: `https://ediary.test${path}` },
        respondWith: (promise) => (responded = promise),
    });
    await responded;
}

test('signed-in pages are never cached', async () => {
    for (const path of ['/home', '/diaries', '/diaries/5/edit', '/diary/stats', '/settings', '/user/shakil']) {
        await visit(path);
    }

    assert.deepEqual([...pages.keys()], []);
});

test('public pages are kept for offline use', async () => {
    await visit('/faq');
    await visit('/blogs/how-to-start-writing-a-diary');

    assert.deepEqual([...pages.keys()], ['/faq', '/blogs/how-to-start-writing-a-diary']);
});
