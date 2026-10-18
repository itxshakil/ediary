import { createHash } from 'node:crypto';
import { readFileSync, writeFileSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

// Reads Vite's manifest and writes public/build/sw-precache.js, which the service worker
// loads with importScripts(). Browsers byte-compare imported scripts on update checks, so
// every new build installs a fresh worker that precaches the new hashed assets and drops
// the old cache, without anyone bumping a cache version by hand.

const rootDir = path.dirname(path.dirname(fileURLToPath(import.meta.url)));
const manifest = JSON.parse(readFileSync(path.join(rootDir, 'public/build/manifest.json'), 'utf8'));

const assets = [
    ...new Set(Object.values(manifest).flatMap((entry) => [entry.file, ...(entry.css ?? [])]).map((file) => `/build/${file}`)),
].sort();

const version = createHash('sha256').update(assets.join('\n')).digest('hex').slice(0, 12);
const outputPath = path.join(rootDir, 'public/build/sw-precache.js');

writeFileSync(outputPath, `self.__EDIARY_BUILD = ${JSON.stringify({ version, assets }, null, 4)};\n`);

console.log(`Wrote ${path.relative(rootDir, outputPath)}: build ${version}, ${assets.length} asset(s).`);
