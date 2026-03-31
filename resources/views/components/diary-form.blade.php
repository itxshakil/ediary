@php
    use App\Enums\Mood;
    use App\Enums\Privacy;
@endphp

@props([
    'title' => 'New Entry',
    'description' => null,
    'containerClass' => '',
    'formId' => 'diary-form',
])

<div
    class="bg-white dark:bg-gray-900 rounded-2xl
           border border-gray-200/70 dark:border-gray-700/60
           shadow-[0_1px_2px_rgba(0,0,0,0.05)]
           transition-all duration-200
           hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)]
           focus-within:ring-2 focus-within:ring-blue-500/40 {{ $containerClass }}">

    <form method="POST" action="{{ route('diary.store') }}" id="{{ $formId }}" class="p-6">
        @csrf

        <div class="flex items-center justify-between mb-5">
            <div>
                <label for="{{ $formId }}-entry" class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $title }}
                </label>

                @if ($description)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <span id="{{ $formId }}-offline-badge"
                      class="hidden px-2 py-1 rounded-full
                             bg-yellow-100/80 dark:bg-yellow-900/30
                             text-yellow-800 dark:text-yellow-200
                             text-xs font-medium">
                    0 pending
                </span>

                <span id="{{ $formId }}-char-count" class="text-xs text-gray-400 dark:text-gray-500">
                    0 characters
                </span>
            </div>
        </div>

        <div class="mb-4">
            <input
                type="text"
                name="title"
                id="{{ $formId }}-title"
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
            id="{{ $formId }}-entry"
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

            <input type="hidden" name="mood" id="{{ $formId }}-mood-input">
        </div>

        <div class="mt-4">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">
                Tags
            </label>

            <div class="flex flex-wrap gap-2 mb-2" id="{{ $formId }}-tags-container"></div>

            <input
                type="text"
                id="{{ $formId }}-tag-input"
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

            <input type="hidden" name="tags" id="{{ $formId }}-tags-hidden" value="{{ old('tags') }}">

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
                id="{{ $formId }}-privacy-select"
                class="w-full px-3 py-2 text-sm
                       text-gray-900 dark:text-white
                       bg-white dark:bg-gray-800
                       border border-gray-200/70 dark:border-gray-700/60
                       rounded-xl
                       focus:ring-2 focus:ring-blue-500/50 focus:border-transparent
                       transition">
                @foreach(Privacy::cases() as $privacy)
                    <option value="{{ $privacy->value }}" @selected(old('privacy', Privacy::Private->value) === $privacy->value)>
                        {{ $privacy->emoji() }} {{ $privacy->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Footer --}}
        <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <span id="{{ $formId }}-offline-indicator" class="hidden text-xs text-yellow-600 dark:text-yellow-400">
                • Offline mode
            </span>

            <button
                type="submit"
                id="{{ $formId }}-submit-btn"
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
    (() => {
        const formId = @js($formId);
        const form = document.getElementById(formId);

        if (!form || form.dataset.diaryFormInitialized === 'true') {
            return;
        }

        form.dataset.diaryFormInitialized = 'true';

        const textarea = document.getElementById(`${formId}-entry`);
        const titleInput = document.getElementById(`${formId}-title`);
        const charCount = document.getElementById(`${formId}-char-count`);
        const offlineIndicator = document.getElementById(`${formId}-offline-indicator`);
        const moodInput = document.getElementById(`${formId}-mood-input`);
        const tagInput = document.getElementById(`${formId}-tag-input`);
        const tagsContainer = document.getElementById(`${formId}-tags-container`);
        const tagsHidden = document.getElementById(`${formId}-tags-hidden`);
        const privacySelect = document.getElementById(`${formId}-privacy-select`);
        const moodButtons = form.querySelectorAll('.mood-btn');
        const suggestedTagButtons = form.querySelectorAll('.suggested-tag');
        const draftPrefix = `${formId}-draft`;
        const draftEntryKey = `${draftPrefix}-entry`;
        const draftTitleKey = `${draftPrefix}-title`;

        let tags = [];
        let formChanged = false;

        const updateTagsDisplay = () => {
            tagsContainer.innerHTML = tags.map(tag => `
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                    #${tag}
                    <button type="button" data-remove-tag="${tag}" class="hover:text-blue-900 dark:hover:text-blue-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </span>
            `).join('');

            tagsHidden.value = tags.join(',');
        };

        const addTag = (tag) => {
            const normalizedTag = tag.trim().toLowerCase().replace(/\s+/g, '-');

            if (!normalizedTag || tags.includes(normalizedTag)) {
                return;
            }

            tags.push(normalizedTag);
            updateTagsDisplay();
            tagInput.value = '';
        };

        const updateOfflineUI = (offline) => {
            if (offline) {
                offlineIndicator.classList.remove('hidden');
            } else {
                offlineIndicator.classList.add('hidden');
            }
        };

        textarea?.addEventListener('input', (event) => {
            const length = event.target.value.length;
            charCount.textContent = `${length.toLocaleString()} character${length !== 1 ? 's' : ''}`;

            if (length > 5000) {
                charCount.classList.add('text-orange-500');
            } else {
                charCount.classList.remove('text-orange-500');
            }

            localStorage.setItem(draftEntryKey, event.target.value);
            formChanged = event.target.value.trim().length > 0;
        });

        titleInput?.addEventListener('input', (event) => {
            localStorage.setItem(draftTitleKey, event.target.value);
        });

        window.addEventListener('load', () => {
            const draftEntry = localStorage.getItem(draftEntryKey);
            const draftTitle = localStorage.getItem(draftTitleKey);

            if (draftEntry && !textarea.value) {
                textarea.value = draftEntry;
                textarea.dispatchEvent(new Event('input'));
            }

            if (draftTitle && !titleInput.value) {
                titleInput.value = draftTitle;
            }

            const existingTags = tagsHidden.value
                .split(',')
                .map(tag => tag.trim())
                .filter(Boolean);

            if (existingTags.length > 0) {
                tags = existingTags;
                updateTagsDisplay();
            }
        }, { once: true });

        moodButtons.forEach((button) => {
            if (button.dataset.mood === moodInput.value) {
                button.classList.add('active');
            }

            button.addEventListener('click', () => {
                moodButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                moodInput.value = button.dataset.mood;
            });
        });

        tagInput?.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                addTag(tagInput.value);
            }
        });

        suggestedTagButtons.forEach((button) => {
            button.addEventListener('click', () => {
                addTag(button.dataset.tag);
            });
        });

        tagsContainer?.addEventListener('click', (event) => {
            const removeButton = event.target.closest('[data-remove-tag]');
            if (!removeButton) {
                return;
            }

            tags = tags.filter(tag => tag !== removeButton.dataset.removeTag);
            updateTagsDisplay();
        });

        form?.addEventListener('submit', async (event) => {
            event.preventDefault();

            const entryValue = textarea.value.trim();
            if (!entryValue) {
                return;
            }

            if (!navigator.onLine) {
                try {
                    await window.offlineManager.saveOfflineEntry({
                        title: titleInput.value,
                        entry: entryValue,
                        mood: moodInput.value,
                        tags,
                        privacy: privacySelect.value,
                    });

                    textarea.value = '';
                    titleInput.value = '';
                    localStorage.removeItem(draftEntryKey);
                    localStorage.removeItem(draftTitleKey);
                    tags = [];
                    updateTagsDisplay();
                    moodInput.value = '';
                    moodButtons.forEach(button => button.classList.remove('active'));
                    formChanged = false;
                } catch (error) {
                    console.error('Failed to save offline:', error);
                    alert('Failed to save entry offline. Please try again.');
                }

                return;
            }

            localStorage.removeItem(draftEntryKey);
            localStorage.removeItem(draftTitleKey);
            form.submit();
        });

        window.addEventListener('online', () => updateOfflineUI(false));
        window.addEventListener('offline', () => updateOfflineUI(true));
        updateOfflineUI(!navigator.onLine);

        textarea?.addEventListener('keydown', (event) => {
            if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
                event.preventDefault();
                form.dispatchEvent(new Event('submit'));
            }
        });

        textarea?.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = `${Math.max(this.scrollHeight, 120)}px`;
        });

        window.addEventListener('beforeunload', (event) => {
            if (formChanged) {
                event.preventDefault();
                event.returnValue = '';
            }
        });
    })();
</script>
