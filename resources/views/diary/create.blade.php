@extends('layouts.app')
@section('title', 'Add new Entry')
@section('content')
    <div class="container mx-auto max-w-2xl px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">New entry</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">What's on your mind today?</p>
        </div>

        <div class="diary-card">
            <form method="POST" action="{{ route('diary.store') }}" id="create-entry-form">
                @csrf

                {{-- Title --}}
                <div class="mb-5">
                    <label for="title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Title <span class="font-normal text-gray-400">(optional)</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Give your entry a title…"
                        class="w-full rounded-xl border border-gray-200 bg-white/60 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800/60 dark:text-white"
                    />
                    @error('title')
                        <p class="mt-1 text-xs text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Entry --}}
                <div class="mb-5">
                    <label for="entry" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Entry <span class="text-red-400">*</span>
                    </label>
                    <textarea
                        id="entry"
                        name="entry"
                        class="notebook auto-grow w-full rounded-xl border border-gray-200 bg-white/60 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800/60 dark:text-white"
                        placeholder="It was an awesome day today…"
                        required
                        autofocus
                    >{{ old('entry') }}</textarea>
                    @error('entry')
                        <p class="mt-1 text-xs text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mood picker --}}
                <div class="mb-5">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mood <span class="font-normal text-gray-400">(optional)</span>
                    </label>
                    <input type="hidden" name="mood" id="mood-input" value="{{ old('mood') }}" />
                    <div class="flex flex-wrap gap-2">
                        @foreach (\App\Enums\Mood::cases() as $mood)
                            <button
                                type="button"
                                data-mood="{{ $mood->value }}"
                                class="mood-btn flex items-center gap-1.5 rounded-full border border-gray-200 dark:border-gray-700 bg-white/60 dark:bg-gray-800/60 px-3 py-1.5 text-sm transition {{ old('mood') === $mood->value ? 'active' : '' }}"
                            >
                                <span>{{ $mood->emoji() }}</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ $mood->label() }}</span>
                            </button>
                        @endforeach
                    </div>
                    @error('mood')
                        <p class="mt-1 text-xs text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tags --}}
                <div class="mb-5">
                    <label for="tags" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tags <span class="font-normal text-gray-400">(optional, comma-separated)</span>
                    </label>
                    <input
                        type="text"
                        id="tags"
                        name="tags"
                        value="{{ old('tags') }}"
                        placeholder="work, gratitude, travel…"
                        class="w-full rounded-xl border border-gray-200 bg-white/60 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800/60 dark:text-white"
                    />
                    @error('tags')
                        <p class="mt-1 text-xs text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Privacy --}}
                <div class="mb-6">
                    <label for="privacy" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Privacy
                    </label>
                    <select
                        id="privacy"
                        name="privacy"
                        class="w-full rounded-xl border border-gray-200 bg-white/60 px-4 py-2.5 text-sm text-gray-900 transition focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800/60 dark:text-white"
                    >
                        @foreach (\App\Enums\Privacy::cases() as $privacy)
                            <option
                                value="{{ $privacy->value }}"
                                {{ old('privacy', 'private') === $privacy->value ? 'selected' : '' }}
                            >
                                {{ $privacy->emoji() }} {{ $privacy->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('privacy')
                        <p class="mt-1 text-xs text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <p id="offline-note" class="mb-3 hidden text-center text-xs text-yellow-600 dark:text-yellow-400">
                    You're offline. Your entry will be saved on this device and synced when you're back online.
                </p>
                <button
                    type="submit"
                    class="w-full rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 active:scale-95"
                >
                    Save entry
                </button>
            </form>
        </div>
    </div>

    <script>
        const createForm = document.getElementById('create-entry-form');
        const titleField = document.getElementById('title');
        const entryField = document.getElementById('entry');
        const tagsField = document.getElementById('tags');
        const privacyField = document.getElementById('privacy');
        const offlineNote = document.getElementById('offline-note');
        const moodInput = document.getElementById('mood-input');

        // Keep a draft so nothing is lost if the connection drops mid-write.
        if (!entryField.value && !titleField.value) {
            entryField.value = localStorage.getItem('diary_draft_entry') || '';
            titleField.value = localStorage.getItem('diary_draft_title') || '';
        }
        entryField.addEventListener('input', () => localStorage.setItem('diary_draft_entry', entryField.value));
        titleField.addEventListener('input', () => localStorage.setItem('diary_draft_title', titleField.value));

        function clearDraft() {
            localStorage.removeItem('diary_draft_entry');
            localStorage.removeItem('diary_draft_title');
        }

        const updateOfflineNote = () => offlineNote.classList.toggle('hidden', navigator.onLine);
        window.addEventListener('online', updateOfflineNote);
        window.addEventListener('offline', updateOfflineNote);
        updateOfflineNote();

        createForm.addEventListener('submit', async (e) => {
            if (navigator.onLine) {
                clearDraft();
                return;
            }

            e.preventDefault();

            try {
                await window.offlineManager.saveOfflineEntry({
                    title: titleField.value,
                    entry: entryField.value.trim(),
                    mood: moodInput.value,
                    tags: tagsField.value,
                    privacy: privacyField.value,
                });
                titleField.value = '';
                entryField.value = '';
                tagsField.value = '';
                privacyField.value = 'private';
                moodInput.value = '';
                document.querySelectorAll('.mood-btn').forEach((b) => b.classList.remove('active'));
                clearDraft();
            } catch (error) {
                console.error('Failed to save offline:', error);
                window.offlineManager?.showNotification(
                    'Could not save offline',
                    'Your text is still in the form. Please try again.',
                    'error',
                );
            }
        });

        document.querySelectorAll('.mood-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.mood-btn').forEach((b) => b.classList.remove('active'));
                if (moodInput.value === btn.dataset.mood) {
                    moodInput.value = '';
                } else {
                    btn.classList.add('active');
                    moodInput.value = btn.dataset.mood;
                }
            });
        });
    </script>
@endsection
