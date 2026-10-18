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
                        class="field w-full"
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
                        class="field notebook auto-grow w-full"
                        placeholder="It was an awesome day today…"
                        required
                        autofocus
                    >{{ old('entry') }}</textarea>
                    <x-dictate-button target="entry" class="mt-2" />
                    @error('entry')
                        <p class="mt-1 text-xs text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mood picker --}}
                <div class="mb-5">
                    <x-mood-picker :selected="old('mood')" legend="Mood" />
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
                        class="field w-full"
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
                    <select id="privacy" name="privacy" class="field w-full">
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
                <x-button size="lg" type="submit" class="w-full"> Save entry </x-button>
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
                    mood: createForm.querySelector('[name="mood"]:checked')?.value ?? '',
                    tags: tagsField.value,
                    privacy: privacyField.value,
                });
                titleField.value = '';
                entryField.value = '';
                tagsField.value = '';
                privacyField.value = 'private';
                createForm.querySelectorAll('[name="mood"]').forEach((radio) => (radio.checked = false));
                clearDraft();
            } catch (error) {
                console.error('Failed to save offline:', error);
                window.toast?.({
                    type: 'error',
                    title: 'Could not save offline',
                    message: 'Your text is still in the form. Please try again.',
                });
            }
        });
    </script>
@endsection
