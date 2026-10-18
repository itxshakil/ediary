class OfflineManager {
    constructor() {
        this.dbName = 'DiaryOfflineDB';
        this.dbVersion = 1;
        this.storeName = 'pendingEntries';
        this.db = null;
        this.isOnline = navigator.onLine;
        this.isSyncing = false;

        this.init();
    }

    async init() {
        await this.initDB();

        window.addEventListener('online', () => this.handleOnline());
        window.addEventListener('offline', () => this.handleOffline());

        // Listen for sync messages from service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.addEventListener('message', (event) => {
                if (event.data.type === 'SYNC_REQUIRED') {
                    this.syncPendingEntries();
                }
            });
        }

        await this.checkPendingEntries();
    }

    async initDB() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);

            request.onerror = () => reject(request.error);
            request.onsuccess = () => {
                this.db = request.result;
                resolve(this.db);
            };

            request.onupgradeneeded = (event) => {
                const db = event.target.result;
                if (!db.objectStoreNames.contains(this.storeName)) {
                    const objectStore = db.createObjectStore(this.storeName, {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                    objectStore.createIndex('timestamp', 'timestamp', { unique: false });
                    objectStore.createIndex('synced', 'synced', { unique: false });
                }
            };
        });
    }

    async saveOfflineEntry(entry) {
        const transaction = this.db.transaction([this.storeName], 'readwrite');
        const store = transaction.objectStore(this.storeName);

        const entryData = {
            ...entry,
            timestamp: Date.now(),
            created_at: new Date().toISOString()
        };

        return new Promise((resolve, reject) => {
            const request = store.add(entryData);
            request.onsuccess = () => {
                this.showNotification('Entry saved offline', 'Will sync when online', 'info');
                this.updatePendingCount();
                this.requestPersistentStorage();
                resolve(request.result);
            };
            request.onerror = () => reject(request.error);
        });
    }

    // Without this the browser may evict IndexedDB under storage pressure, losing unsynced entries.
    async requestPersistentStorage() {
        if (!navigator.storage?.persist) return;

        try {
            if (await navigator.storage.persisted()) return;

            const granted = await navigator.storage.persist();
            console.log('Persistent storage', granted ? 'granted' : 'denied');
        } catch (error) {
            console.error('Persistent storage request failed:', error);
        }
    }

    async getPendingEntries() {
        const transaction = this.db.transaction([this.storeName], 'readonly');
        const store = transaction.objectStore(this.storeName);

        return new Promise((resolve, reject) => {
            const request = store.getAll();
            request.onsuccess = () => resolve(request.result.map((record) => this.toPayload(record)));
            request.onerror = () => reject(request.error);
        });
    }

    // Older versions stored the form fields nested under `entry`; flatten them so those entries still sync.
    toPayload(record) {
        const fields = typeof record.entry === 'object' && record.entry !== null ? record.entry : record;
        const tags = Array.isArray(fields.tags) ? fields.tags.join(',') : (fields.tags || '');

        return {
            id: record.id,
            body: {
                title: fields.title || null,
                entry: fields.entry,
                mood: fields.mood || null,
                tags: tags,
                privacy: fields.privacy || null,
                created_at: record.created_at
            }
        };
    }

    async syncPendingEntries() {
        if (!this.isOnline || this.isSyncing) return;

        this.isSyncing = true;

        try {
            const pendingEntries = await this.getPendingEntries();

            if (pendingEntries.length === 0) return;

            this.showNotification('Syncing...', `${pendingEntries.length} offline entries`, 'info');

            let successCount = 0;
            let failCount = 0;

            for (const entry of pendingEntries) {
                try {
                    const response = await fetch('/diary/sync', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(entry.body)
                    });

                    if (response.ok) {
                        await this.deletePendingEntry(entry.id);
                        successCount++;
                    } else {
                        failCount++;
                        console.error('Failed to sync entry:', entry.id, response.status);
                    }
                } catch (error) {
                    failCount++;
                    console.error('Error syncing entry:', error);
                }
            }

            if (successCount > 0) {
                this.showNotification(
                    'Sync complete!',
                    `${successCount} entries synced${failCount > 0 ? `, ${failCount} failed` : ''}`,
                    failCount > 0 ? 'warning' : 'success'
                );

                await this.updatePendingCount();

                setTimeout(() => window.location.reload(), 2000);
            } else if (failCount > 0) {
                await this.updatePendingCount();
                this.showNotification('Sync failed', 'Your entries are still saved on this device. Will retry later.', 'error');
            }

        } catch (error) {
            console.error('Sync failed:', error);
            this.showNotification('Sync failed', 'Will retry later', 'error');
        } finally {
            this.isSyncing = false;
        }
    }

    async deletePendingEntry(id) {
        const transaction = this.db.transaction([this.storeName], 'readwrite');
        const store = transaction.objectStore(this.storeName);

        return new Promise((resolve, reject) => {
            const request = store.delete(id);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    async checkPendingEntries() {
        const pendingEntries = await this.getPendingEntries();
        if (pendingEntries.length > 0) {
            await this.updatePendingCount();
            if (this.isOnline) {
                await this.syncPendingEntries();
            }
        }
    }

    async updatePendingCount() {
        const pendingEntries = await this.getPendingEntries();
        const badge = document.getElementById('offline-badge');

        if (badge) {
            if (pendingEntries.length > 0) {
                badge.textContent = `${pendingEntries.length} pending`;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    async handleOnline() {
        this.isOnline = true;
        this.showNotification('Back online!', 'Syncing your offline entries...', 'success');
        this.updateConnectionStatus(true);
        await this.syncPendingEntries();
    }

    handleOffline() {
        this.isOnline = false;
        this.showNotification('You\'re offline', 'Your entries will be saved locally', 'warning');
        this.updateConnectionStatus(false);
    }

    updateConnectionStatus(online) {
        const statusEl = document.getElementById('connection-status');
        if (statusEl) {
            statusEl.className = online
                ? 'hidden'
                : 'fixed top-0 left-0 right-0 bg-yellow-500 text-white text-center py-2 text-sm font-medium z-50';
            statusEl.textContent = online ? '' : '⚠️ You\'re offline - entries will be saved locally';
        }
    }

    showNotification(title, message, type = 'info') {
        if (window.toast) {
            window.toast({ type, title, message });
        } else {
            console.info(`[${type}] ${title}: ${message}`);
        }
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.offlineManager = new OfflineManager();
    });
} else {
    window.offlineManager = new OfflineManager();
}
