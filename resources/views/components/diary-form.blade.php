@php
    use App\Enums\Mood;
    use App\Enums\Privacy;
@endphp

<div class="focus-within:ring-primary-500/40 shadow-card hover:shadow-card-hover rounded-2xl border border-gray-200/70 bg-white transition-all duration-200 focus-within:ring-2 dark:border-gray-700/60 dark:bg-gray-900">
    <form method="POST" action="{{ route('diary.store') }}" id="diary-form" class="p-6">
        @csrf

        <div class="mb-5 flex items-center justify-between">
            <label for="entry" class="text-lg font-semibold text-gray-900 dark:text-white"> New Entry </label>

            <div class="flex items-center gap-3">
                <span
                    id="offline-badge"
                    class="hidden rounded-full bg-yellow-100/80 px-2 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200"
                >
                    0 pending
                </span>

                <span id="char-count" class="text-xs text-gray-400 dark:text-gray-500"> 0 characters </span>
            </div>
        </div>

        <div class="mb-4">
            <input
                type="text"
                name="title"
                id="title"
                placeholder="Entry title (optional)"
                value="{{ old('title') }}"
                class="field w-full text-lg font-medium"
            />
        </div>

        <textarea
            id="entry"
            name="entry"
            rows="6"
            required
            placeholder="Dear diary, today I..."
            class="field min-h-[120px] w-full resize-y"
        >{{ old('entry') }}</textarea>
        <x-dictate-button target="entry" class="mt-3" />
        @error('entry')
            <div class="mt-3 flex items-center gap-2 rounded-xl bg-red-50/80 px-3 py-2 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                {{ $message }}
            </div>
        @enderror

        <x-mood-picker class="mt-4" />

        <div class="mt-4">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"> Tags </label>

            <div class="mb-2 flex flex-wrap gap-2" id="tags-container"></div>

            <input type="text" id="tag-input" placeholder="Add tags (press Enter)" class="field w-full" />

            <input type="hidden" name="tags" id="tags-hidden" />

            <div class="mt-2 flex flex-wrap gap-2">
                <span class="text-xs text-gray-500 dark:text-gray-400">Popular:</span>
                @foreach (['gratitude', 'work', 'family', 'health', 'goals', 'travel', 'thoughts'] as $tag)
                    <button type="button" data-tag="{{ $tag }}" class="suggested-tag chip min-h-8 px-3 text-xs">
                        #{{ $tag }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Privacy --}}
        <div class="mt-5 rounded-2xl bg-gray-50/70 p-4 dark:bg-gray-900/40">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"> Privacy </label>

            <select name="privacy" id="privacy-select" class="field w-full">
                @foreach (Privacy::cases() as $privacy)
                    <option value="{{ $privacy->value }}" @selected($privacy === Privacy::Private)>
                        {{ $privacy->emoji() }} {{ $privacy->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Footer --}}
        <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <span id="offline-indicator" class="hidden text-xs text-yellow-600 dark:text-yellow-400">
                • Offline mode
            </span>

            <x-button type="submit" id="submit-btn">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Publish Entry</span>
            </x-button>
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

    const clearMood = () => form.querySelectorAll('[name="mood"]').forEach((radio) => (radio.checked = false));

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
        tags = tags.filter((t) => t !== tag);
        updateTagsDisplay();
    }

    function updateTagsDisplay() {
        tagsContainer.replaceChildren(
            ...tags.map((tag) => {
                const chip = document.createElement('span');
                chip.className = 'chip-tag';
                chip.textContent = `#${tag}`;

                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = '-mr-1 grid size-5 place-items-center rounded-full hover:bg-primary-500/20';
                remove.setAttribute('aria-label', `Remove tag ${tag}`);
                remove.innerHTML =
                    '<svg aria-hidden="true" class="size-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>';
                remove.addEventListener('click', () => removeTag(tag));

                chip.append(remove);
                return chip;
            }),
        );

        tagsHidden.value = tags.join(',');
    }

    tagInput?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTag(tagInput.value);
        }
    });

    // Suggested tags
    document.querySelectorAll('.suggested-tag').forEach((btn) => {
        btn.addEventListener('click', () => {
            addTag(btn.dataset.tag);
        });
    });

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
                    mood: form.querySelector('[name="mood"]:checked')?.value ?? '',
                    tags: tags,
                    privacy: document.getElementById('privacy-select').value,
                });
                textarea.value = '';
                titleInput.value = '';
                localStorage.removeItem('diary_draft_entry');
                localStorage.removeItem('diary_draft_title');
                tags = [];
                updateTagsDisplay();
                clearMood();
                formChanged = false;
            } catch (error) {
                console.error('Failed to save offline:', error);
                window.toast?.({
                    type: 'error',
                    title: 'Could not save offline',
                    message: 'Your text is still in the form. Please try again.',
                });
            }
        } else {
            localStorage.removeItem('diary_draft_entry');
            localStorage.removeItem('diary_draft_title');
            form.submit();
        }
    });

    // Update offline indicator
    function updateOfflineUI(offline) {
        offlineIndicator.classList.toggle('hidden', !offline);
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
