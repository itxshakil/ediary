import { toast } from './toast';

const DB_NAME = 'DiaryOfflineDB';
const DB_VERSION = 2;
const STORE = 'pendingEntries';

/**
 * Entries written without a connection, kept in IndexedDB until they reach the server.
 * Each record is { id, title, entry, mood, tags, privacy, created_at } with tags as a comma-separated string.
 */
class OfflineStore {
    constructor() {
        this.db = null;
        this.isSyncing = false;
        this.ready = this.open();
    }

    open() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(DB_NAME, DB_VERSION);

            request.onerror = () => reject(request.error);
            request.onsuccess = () => {
                this.db = request.result;
                resolve(this.db);
            };
            request.onupgradeneeded = (event) => {
                const db = request.result;
                const store = db.objectStoreNames.contains(STORE)
                    ? request.transaction.objectStore(STORE)
                    : db.createObjectStore(STORE, { keyPath: 'id', autoIncrement: true });

                if (event.oldVersion === 1) {
                    migrateFromV1(store);
                }
            };
        });
    }

    async run(mode, operation) {
        await this.ready;

        return new Promise((resolve, reject) => {
            const request = operation(this.db.transaction(STORE, mode).objectStore(STORE));
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    async save(fields) {
        const id = await this.run('readwrite', (store) => store.add({ ...fields, created_at: new Date().toISOString() }));

        toast({ type: 'info', title: 'Entry saved offline', message: 'It will sync when you are back online.' });
        this.updateBadge();
        requestPersistentStorage();

        return id;
    }

    count() {
        return this.run('readonly', (store) => store.count());
    }

    async updateBadge() {
        const badge = document.getElementById('offline-badge');
        if (!badge) return;

        const pending = await this.count();
        badge.textContent = `${pending} pending`;
        badge.classList.toggle('hidden', pending === 0);
    }

    async sync() {
        if (!navigator.onLine || this.isSyncing) return;

        this.isSyncing = true;

        try {
            const entries = await this.run('readonly', (store) => store.getAll());
            if (entries.length === 0) return;

            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const results = await Promise.allSettled(
                entries.map(async ({ id, ...fields }) => {
                    const response = await fetch('/diary/sync', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': csrf },
                        body: JSON.stringify(fields),
                    });

                    if (!response.ok) {
                        throw new Error(`Sync of entry ${id} failed with ${response.status}`);
                    }

                    await this.run('readwrite', (store) => store.delete(id));
                }),
            );

            const failed = results.filter((result) => result.status === 'rejected');
            failed.forEach((result) => console.error(result.reason));
            const synced = results.length - failed.length;

            await this.updateBadge();

            if (synced > 0) {
                toast({
                    type: failed.length > 0 ? 'warning' : 'success',
                    title: 'Sync complete',
                    message: `${synced} ${synced === 1 ? 'entry' : 'entries'} synced${failed.length > 0 ? `, ${failed.length} failed` : ''}.`,
                });
                setTimeout(() => window.location.reload(), 2000);
            } else {
                toast({ type: 'error', title: 'Sync failed', message: 'Your entries are still saved on this device. Will retry later.' });
            }
        } catch (error) {
            console.error('Sync failed:', error);
            toast({ type: 'error', title: 'Sync failed', message: 'Will retry later.' });
        } finally {
            this.isSyncing = false;
        }
    }
}

// v1 nested the form fields under `entry`, kept synced rows around and indexed unused fields.
function migrateFromV1(store) {
    ['timestamp', 'synced'].forEach((index) => store.indexNames.contains(index) && store.deleteIndex(index));

    store.openCursor().onsuccess = (event) => {
        const cursor = event.target.result;
        if (!cursor) return;

        const { id, entry, synced, created_at } = cursor.value;
        if (synced === true) {
            cursor.delete();
        } else if (typeof entry === 'object' && entry !== null) {
            const tags = Array.isArray(entry.tags) ? entry.tags.join(',') : (entry.tags ?? '');
            cursor.update({ id, title: entry.title, entry: entry.entry, mood: entry.mood, tags, privacy: entry.privacy, created_at });
        }
        cursor.continue();
    };
}

// Without this the browser may evict IndexedDB under storage pressure, losing unsynced entries.
async function requestPersistentStorage() {
    if (!navigator.storage?.persist) return;

    try {
        if (!(await navigator.storage.persisted())) {
            await navigator.storage.persist();
        }
    } catch (error) {
        console.error('Persistent storage request failed:', error);
    }
}

export const offlineStore = new OfflineStore();

function showConnectionBanner(online) {
    const banner = document.getElementById('connection-status');
    if (!banner) return;

    banner.className = online ? 'hidden' : 'fixed inset-x-0 top-0 z-50 bg-yellow-500 py-2 text-center text-sm font-medium text-white';
    banner.textContent = online ? '' : "⚠️ You're offline - entries will be saved locally";
}

export function initOfflineSync() {
    // Pending entries belong to a signed-in person; on guest pages a sync would only fail.
    if (!document.body.hasAttribute('data-signed-in')) return;

    window.addEventListener('online', () => {
        showConnectionBanner(true);
        toast({ type: 'success', title: 'Back online', message: 'Syncing your offline entries…' });
        offlineStore.sync();
    });
    window.addEventListener('offline', () => {
        showConnectionBanner(false);
        toast({ type: 'warning', title: "You're offline", message: 'Your entries will be saved on this device.' });
    });
    navigator.serviceWorker?.addEventListener('message', (event) => {
        if (event.data?.type === 'SYNC_REQUIRED') {
            offlineStore.sync();
        }
    });

    offlineStore.updateBadge();
    offlineStore.sync();
}
