class OfflineManager {
    constructor() {
        this.dbName = 'DiaryOfflineDB';
        this.dbVersion = 1;
        this.storeName = 'pendingEntries';
        this.db = null;
        this.isOnline = navigator.onLine;

        this.init();
    }

    async init() {
        await this.initDB();

        if ('serviceWorker' in navigator) {
            try {
                const registration = await navigator.serviceWorker.register('/service-worker.js');
                console.log('Service Worker registered:', registration);
            } catch (error) {
                console.error('Service Worker registration failed:', error);
            }
        }

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
            entry: entry,
            timestamp: Date.now(),
            synced: false,
            created_at: new Date().toISOString()
        };

        return new Promise((resolve, reject) => {
            const request = store.add(entryData);
            request.onsuccess = () => {
                this.showNotification('Entry saved offline', 'Will sync when online', 'info');
                this.updatePendingCount();
                resolve(request.result);
            };
            request.onerror = () => reject(request.error);
        });
    }

    async getPendingEntries() {
        const transaction = this.db.transaction([this.storeName], 'readonly');
        const store = transaction.objectStore(this.storeName);
        const index = store.index('synced');

        return new Promise((resolve, reject) => {
            const request = index.getAll(IDBKeyRange.only(false));
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    async syncPendingEntries() {
        if (!this.isOnline) return;

        try {
            const pendingEntries = await this.getPendingEntries();

            if (pendingEntries.length === 0) return;

            this.showNotification('Syncing...', `${pendingEntries.length} offline entries`, 'info');

            let successCount = 0;
            let failCount = 0;

            for (const entry of pendingEntries) {
                try {
                    const response = await fetch('/diary/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            entry: entry.entry,
                            created_at: entry.created_at
                        })
                    });

                    if (response.ok) {
                        await this.markAsSynced(entry.id);
                        successCount++;
                    } else {
                        failCount++;
                        console.error('Failed to sync entry:', entry.id);
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
            }

        } catch (error) {
            console.error('Sync failed:', error);
            this.showNotification('Sync failed', 'Will retry later', 'error');
        }
    }

    async markAsSynced(id) {
        const transaction = this.db.transaction([this.storeName], 'readwrite');
        const store = transaction.objectStore(this.storeName);

        return new Promise((resolve, reject) => {
            const getRequest = store.get(id);
            getRequest.onsuccess = () => {
                const entry = getRequest.result;
                entry.synced = true;
                const updateRequest = store.put(entry);
                updateRequest.onsuccess = () => resolve();
                updateRequest.onerror = () => reject(updateRequest.error);
            };
            getRequest.onerror = () => reject(getRequest.error);
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
                badge.textContent = pendingEntries.length;
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
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };

        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };

        const notification = document.createElement('div');
        notification.className = `fixed top-6 right-6 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-xl max-w-sm z-50 animate-slide-down`;
        notification.innerHTML = `
            <div class="flex items-start gap-3">
                <span class="text-xl">${icons[type]}</span>
                <div class="flex-1">
                    <div class="font-semibold">${title}</div>
                    <div class="text-sm opacity-90">${message}</div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.offlineManager = new OfflineManager();
    });
} else {
    window.offlineManager = new OfflineManager();
}
