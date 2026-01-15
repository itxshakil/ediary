@php use App\Enums\Mood;use App\Enums\Privacy; @endphp

<div
    class="bg-white dark:bg-gray-900 rounded-2xl
           border border-gray-200/70 dark:border-gray-700/60
           shadow-[0_1px_2px_rgba(0,0,0,0.05)]
           transition-all duration-200
           hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)]
           focus-within:ring-2 focus-within:ring-blue-500/40">

    <form method="POST" action="{{ route('diary.store') }}" id="diary-form" class="p-6">
        @csrf

        <div class="flex items-center justify-between mb-5">
            <label for="entry" class="text-lg font-semibold text-gray-900 dark:text-white">
                New Entry
            </label>

            <div class="flex items-center gap-3">
                <span id="offline-badge"
                      class="hidden px-2 py-1 rounded-full
                             bg-yellow-100/80 dark:bg-yellow-900/30
                             text-yellow-800 dark:text-yellow-200
                             text-xs font-medium">
                    0 pending
                </span>

                <span id="char-count" class="text-xs text-gray-400 dark:text-gray-500">
                    0 characters
                </span>
            </div>
        </div>

        <div class="mb-4">
            <input
                type="text"
                name="title"
                id="title"
                placeholder="Entry title (optional)"
                value="{{ old('title') }}"
                class="w-full px-4 py-3 text-lg font-medium
                       text-gray-900 dark:text-white
                       bg-gray-50/80 dark:bg-gray-900/60
                       border border-gray-200/70 dark:border-gray-700/60
                       rounded-xl
                       placeholder-gray-400 dark:placeholder-gray-500
                       focus:ring-2 focus:ring-blue-500/50 focus:border-transparent
                       transition"
            />
        </div>

        <textarea
            id="entry"
            name="entry"
            rows="6"
            required
            placeholder="Dear diary, today I..."
            class="w-full px-4 py-3
                   text-gray-900 dark:text-white
                   bg-gray-50/80 dark:bg-gray-900/60
                   border border-gray-200/70 dark:border-gray-700/60
                   rounded-xl resize-y min-h-[120px]
                   placeholder-gray-400 dark:placeholder-gray-500
                   focus:ring-2 focus:ring-blue-500/50 focus:border-transparent
                   transition"
        >{{ old('entry') }}</textarea>

        @error('entry')
        <div
            class="mt-3 flex items-center gap-2 text-sm
                   text-red-600 dark:text-red-400
                   bg-red-50/80 dark:bg-red-900/20
                   px-3 py-2 rounded-xl">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $message }}
        </div>
        @enderror

        {{-- Mood --}}
        <div class="mt-4">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">
                How are you feeling?
            </label>

            <div class="flex gap-2 flex-wrap" id="mood-selector">
                @foreach(Mood::cases() as $mood)
                    <button
                        type="button"
                        data-mood="{{ $mood->value }}"
                        title="{{ $mood->label() }}"
                        class="mood-btn p-1 md:p-3 text-2xl rounded-xl
                               border border-transparent
                               hover:bg-gray-100 dark:hover:bg-gray-800
                               active:scale-95
                               transition">
                        {{ $mood->emoji() }}
                    </button>
                @endforeach
            </div>

            <input type="hidden" name="mood" id="mood-input">
        </div>

        <div class="mt-4">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">
                Tags
            </label>

            <div class="flex flex-wrap gap-2 mb-2" id="tags-container"></div>

            <input
                type="text"
                id="tag-input"
                placeholder="Add tags (press Enter)"
                class="w-full px-3 py-2 text-sm
                       text-gray-900 dark:text-white
                       bg-gray-50/80 dark:bg-gray-900/60
                       border border-gray-200/70 dark:border-gray-700/60
                       rounded-xl
                       placeholder-gray-400
                       focus:ring-2 focus:ring-blue-500/50 focus:border-transparent
                       transition"
            />

            <input type="hidden" name="tags" id="tags-hidden">

            <div class="mt-2 flex flex-wrap gap-2">
                <span class="text-xs text-gray-500 dark:text-gray-400">Popular:</span>
                @foreach(['gratitude','work','family','health','goals','travel','thoughts'] as $tag)
                    <button
                        type="button"
                        data-tag="{{ $tag }}"
                        class="suggested-tag px-2 py-1 text-xs
                               bg-gray-100/70 dark:bg-gray-700/60
                               text-gray-600 dark:text-gray-300
                               rounded-full
                               hover:bg-blue-100/70 dark:hover:bg-blue-900/30
                               hover:text-blue-600 dark:hover:text-blue-400
                               transition">
                        #{{ $tag }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Privacy --}}
        <div class="mt-5 p-4 bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">
                Privacy
            </label>

            <select
                name="privacy"
                id="privacy-select"
                class="w-full px-3 py-2 text-sm
                       text-gray-900 dark:text-white
                       bg-white dark:bg-gray-800
                       border border-gray-200/70 dark:border-gray-700/60
                       rounded-xl
                       focus:ring-2 focus:ring-blue-500/50 focus:border-transparent
                       transition">
                @foreach(Privacy::cases() as $privacy)
                    <option value="{{ $privacy->value }}" @selected($privacy === Privacy::Private)>
                        {{ $privacy->emoji() }} {{ $privacy->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Footer --}}
        <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <span id="offline-indicator" class="hidden text-xs text-yellow-600 dark:text-yellow-400">
                • Offline mode
            </span>

            <button
                type="submit"
                id="submit-btn"
                class="inline-flex items-center gap-2
                       px-6 py-2.5
                       bg-blue-600 hover:bg-blue-700
                       text-white font-medium
                       rounded-full
                       shadow-sm hover:shadow-md
                       transition
                       focus:ring-2 focus:ring-blue-500/60
                       focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Publish Entry</span>
            </button>
        </div>

    </form>
</div>

<script>
    const textarea = document.getElementById('entry');
    const titleInput = document.getElementById('title');
    const charCount = document.getElementById('char-count');
    const submitBtn = document.getElementById('submit-btn');
    const form = document.getElementById('diary-form');
    const offlineIndicator = document.getElementById('offline-indicator');
    const syncBtn = document.getElementById('sync-btn');

    // Character counter
    textarea?.addEventListener('input', (e) => {
        const length = e.target.value.length;
        charCount.textContent = `${length.toLocaleString()} character${length !== 1 ? 's' : ''}`;

        if (length > 5000) {
            charCount.classList.add('text-orange-500');
        } else {
            charCount.classList.remove('text-orange-500');
        }

        localStorage.setItem('diary_draft_entry', e.target.value);
    });

    titleInput?.addEventListener('input', (e) => {
        localStorage.setItem('diary_draft_title', e.target.value);
    });

    window.addEventListener('load', () => {
        const draftEntry = localStorage.getItem('diary_draft_entry');
        const draftTitle = localStorage.getItem('diary_draft_title');

        if (draftEntry && !textarea.value) {
            textarea.value = draftEntry;
            // Trigger auto-resize and char count
            textarea.dispatchEvent(new Event('input'));
        }
        if (draftTitle && !titleInput.value) {
            titleInput.value = draftTitle;
        }
    });

    const moodBtns = document.querySelectorAll('.mood-btn');
    const moodInput = document.getElementById('mood-input');

    moodBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            moodBtns.forEach(b => b.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20'));
            btn.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
            moodInput.value = btn.dataset.mood;
        });
    });

    // Tags Management
    let tags = [];
    const tagInput = document.getElementById('tag-input');
    const tagsContainer = document.getElementById('tags-container');
    const tagsHidden = document.getElementById('tags-hidden');

    function addTag(tag) {
        tag = tag.trim().toLowerCase().replace(/\s+/g, '-');
        if (!tag || tags.includes(tag)) return;

        tags.push(tag);
        updateTagsDisplay();
        tagInput.value = '';
    }

    function removeTag(tag) {
        tags = tags.filter(t => t !== tag);
        updateTagsDisplay();
    }

    function updateTagsDisplay() {
        tagsContainer.innerHTML = tags.map(tag => `
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                #${tag}
                <button type="button" onclick="removeTag('${tag}')" class="hover:text-blue-900 dark:hover:text-blue-100">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </span>
        `).join('');

        tagsHidden.value = tags.join(',');
    }

    tagInput?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTag(tagInput.value);
        }
    });

    // Suggested tags
    document.querySelectorAll('.suggested-tag').forEach(btn => {
        btn.addEventListener('click', () => {
            addTag(btn.dataset.tag);
        });
    });

    // Make removeTag global
    window.removeTag = removeTag;

    // Handle form submission (online/offline)
    form?.addEventListener('submit', async (e) => {
        e.preventDefault();

        const entryValue = textarea.value.trim();
        if (!entryValue) return;

        if (!navigator.onLine) {
            try {
                await window.offlineManager.saveOfflineEntry({
                    title: titleInput.value,
                    entry: entryValue,
                    mood: moodInput.value,
                    tags: tags,
                    privacy: document.getElementById('privacy-select').value
                });
                textarea.value = '';
                titleInput.value = '';
                localStorage.removeItem('diary_draft_entry');
                localStorage.removeItem('diary_draft_title');
                tags = [];
                updateTagsDisplay();
                moodInput.value = '';
                moodBtns.forEach(b => b.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20'));
                formChanged = false;
            } catch (error) {
                console.error('Failed to save offline:', error);
                alert('Failed to save entry offline. Please try again.');
            }
        } else {
            localStorage.removeItem('diary_draft_entry');
            localStorage.removeItem('diary_draft_title');
            form.submit();
        }
    });

    // Update offline indicator
    function updateOfflineUI(offline) {
        if (offline) {
            offlineIndicator.classList.remove('hidden');
            syncBtn.classList.remove('hidden');
            syncBtn.classList.add('inline-flex');
        } else {
            offlineIndicator.classList.add('hidden');
            syncBtn.classList.add('hidden');
            syncBtn.classList.remove('inline-flex');
        }
    }

    window.addEventListener('online', () => updateOfflineUI(false));
    window.addEventListener('offline', () => updateOfflineUI(true));
    updateOfflineUI(!navigator.onLine);

    // Ctrl+Enter to submit
    textarea?.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });

    // Auto-resize textarea
    textarea?.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.max(this.scrollHeight, 120) + 'px';
    });

    // Prevent accidental navigation
    let formChanged = false;
    textarea?.addEventListener('input', () => {
        formChanged = textarea.value.trim().length > 0;
    });

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
