// Captures full-page screenshots of key pages at mobile and desktop widths in light and dark
// mode, and fails when any page scrolls horizontally. Drives a local Chrome over the DevTools
// protocol, so it needs no npm dependencies.
//
//   node scripts/ui-screenshots.mjs [outDir]
//
// Env: BASE_URL (default http://ediary.test), CHROME_PATH, and E2E_USERNAME (username or email) / E2E_PASSWORD
// to also capture signed-in pages. Use a local test account only.

import { spawn } from 'node:child_process';
import { mkdirSync, mkdtempSync, rmSync, writeFileSync } from 'node:fs';
import { tmpdir } from 'node:os';
import path from 'node:path';

const BASE = process.env.BASE_URL ?? 'http://ediary.test';
const CHROME = process.env.CHROME_PATH ?? '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const OUT = path.resolve(process.argv[2] ?? 'storage/app/ui-screenshots');
const PORT = 9400 + Math.floor(Math.random() * 500);

const GUEST_PAGES = ['/', '/about', '/faq', '/security', '/for-students', '/blog', '/blogs/how-to-keep-a-study-journal', '/journal-prompts', '/journal-prompts/gratitude', '/mood-journal', '/voice-journal', '/private-diary', '/contact', '/login', '/register'];
const AUTH_PAGES = ['/home', '/diaries', '/diaries/create', '/diary/stats', '/settings'];
const VIEWPORTS = [
    { name: 'mobile', width: 390, height: 844, mobile: true },
    { name: 'desktop', width: 1280, height: 800, mobile: false },
];
const SCHEMES = ['light', 'dark'];

// Freeze anything that would make two runs of the same page render differently.
const STABILISE_CSS = `*, *::before, *::after { animation: none !important; transition: none !important; caret-color: transparent !important; }
    #phpdebugbar, .phpdebugbar { display: none !important; }
    body:has(.phpdebugbar) { padding-bottom: 0 !important; }`;

const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

const profile = mkdtempSync(path.join(tmpdir(), 'ediary-ui-'));
const chrome = spawn(CHROME, [
    '--headless=new', `--remote-debugging-port=${PORT}`, `--user-data-dir=${profile}`, '--hide-scrollbars',
    '--no-first-run', '--no-default-browser-check', `--unsafely-treat-insecure-origin-as-secure=${BASE}`, 'about:blank',
], { stdio: 'ignore' });

let socket;
let nextId = 1;
const pending = new Map();

function send(method, params = {}) {
    const id = nextId++;
    socket.send(JSON.stringify({ id, method, params }));
    return new Promise((resolve, reject) => pending.set(id, (msg) => (msg.error ? reject(new Error(msg.error.message)) : resolve(msg.result))));
}

async function evaluate(expression) {
    const result = await send('Runtime.evaluate', { expression, awaitPromise: true, returnByValue: true });
    if (result.exceptionDetails) {
        throw new Error(result.exceptionDetails.exception?.description ?? 'evaluate failed');
    }
    return result.result.value;
}

async function connect() {
    for (let attempt = 0; attempt < 50; attempt++) {
        try {
            const targets = await (await fetch(`http://127.0.0.1:${PORT}/json`)).json();
            const page = targets.find((target) => target.type === 'page');
            if (page) {
                socket = new WebSocket(page.webSocketDebuggerUrl);
                await new Promise((resolve) => socket.addEventListener('open', resolve));
                socket.addEventListener('message', (event) => {
                    const msg = JSON.parse(event.data);
                    pending.get(msg.id)?.(msg);
                    pending.delete(msg.id);
                });
                return;
            }
        } catch {
            // Chrome is still starting.
        }
        await sleep(200);
    }
    throw new Error('Could not connect to Chrome');
}

async function open(url) {
    await send('Page.navigate', { url });
    await evaluate(`new Promise((resolve) => document.readyState === 'complete' ? resolve() : addEventListener('load', resolve))`);
    await evaluate(`document.fonts.ready.then(() => true)`);
    await sleep(300);
}

async function signIn() {
    await open(`${BASE}/login`);
    await evaluate(`(() => {
        document.querySelector('[name=login]').value = ${JSON.stringify(process.env.E2E_USERNAME)};
        document.querySelector('[name=password]').value = ${JSON.stringify(process.env.E2E_PASSWORD)};
        document.querySelector('[name=password]').form.submit();
    })()`);
    await sleep(2500);
    return (await evaluate('location.pathname')) !== '/login';
}

async function capture(page, viewport, scheme) {
    await send('Emulation.setDeviceMetricsOverride', { width: viewport.width, height: viewport.height, deviceScaleFactor: 1, mobile: viewport.mobile });
    await send('Emulation.setEmulatedMedia', { features: [{ name: 'prefers-color-scheme', value: scheme }] });
    await open(`${BASE}${page}`);
    await evaluate(`(() => { const s = document.createElement('style'); s.textContent = ${JSON.stringify(STABILISE_CSS)}; document.head.append(s); })()`);
    await sleep(200);

    const overflow = await evaluate(`document.documentElement.scrollWidth - document.documentElement.clientWidth`);
    const { cssContentSize } = await send('Page.getLayoutMetrics');
    const shot = await send('Page.captureScreenshot', {
        format: 'png',
        captureBeyondViewport: true,
        clip: { x: 0, y: 0, width: viewport.width, height: Math.ceil(cssContentSize.height), scale: 1 },
    });

    const slug = page === '/' ? 'home-page' : page.slice(1).replaceAll('/', '-');
    writeFileSync(path.join(OUT, `${slug}--${viewport.name}--${scheme}.png`), Buffer.from(shot.data, 'base64'));

    return overflow > 0 ? `${page} (${viewport.name}, ${scheme}) overflows by ${overflow}px` : null;
}

const problems = [];

try {
    mkdirSync(OUT, { recursive: true });
    await connect();
    await send('Page.enable');
    await send('Runtime.enable');

    const pages = [...GUEST_PAGES];
    if (process.env.E2E_USERNAME && process.env.E2E_PASSWORD) {
        await send('Emulation.setDeviceMetricsOverride', { width: 1280, height: 800, deviceScaleFactor: 1, mobile: false });
        if (await signIn()) {
            pages.push(...AUTH_PAGES);
            pages.splice(pages.indexOf('/login'), 2);
        } else {
            problems.push('Sign-in failed; captured guest pages only');
        }
    }

    for (const page of pages) {
        for (const viewport of VIEWPORTS) {
            for (const scheme of SCHEMES) {
                const problem = await capture(page, viewport, scheme);
                if (problem) problems.push(problem);
            }
        }
    }

    console.log(`Saved ${pages.length * VIEWPORTS.length * SCHEMES.length} screenshots to ${path.relative(process.cwd(), OUT) || OUT}`);
} finally {
    socket?.close();
    chrome.kill();
    await sleep(300);
    rmSync(profile, { recursive: true, force: true });
}

if (problems.length > 0) {
    console.error(`\n${problems.length} problem(s):\n- ${problems.join('\n- ')}`);
    process.exit(1);
}
