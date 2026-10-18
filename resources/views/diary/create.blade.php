@extends('layouts.app')
@section('title', 'Add new Entry')
@section('content')
    <div class="container mx-auto max-w-2xl px-4 py-8">
        <x-page-header title="New entry" subtitle="What's on your mind today?" />

        <x-card>
            <form method="POST" action="{{ route('diary.store') }}" data-entry-form>
                @csrf

                <div class="mb-5">
                    <x-form.label for="title">
                        Title <span class="font-normal text-gray-400">(optional)</span></x-form.label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Give your entry a title…"
                        class="field"
                    />
                    <x-form.error name="title" />
                </div>

                <div class="mb-5">
                    <x-form.label for="entry">Entry <span class="text-red-400">*</span></x-form.label>
                    <textarea
                        id="entry"
                        name="entry"
                        class="field notebook"
                        placeholder="It was an awesome day today…"
                        required
                        autofocus
                    >{{ old('entry') }}</textarea>
                    <x-dictate-button target="entry" class="mt-2" />
                    <x-form.error name="entry" />
                </div>

                <div class="mb-5">
                    <x-mood-picker :selected="old('mood')" legend="Mood" />
                    <x-form.error name="mood" />
                </div>

                <div class="mb-5">
                    <x-form.label for="tags">
                        Tags <span class="font-normal text-gray-400">(optional, comma-separated)</span></x-form.label>
                    <input
                        type="text"
                        id="tags"
                        name="tags"
                        value="{{ old('tags') }}"
                        placeholder="work, gratitude, travel…"
                        class="field"
                    />
                    <x-form.error name="tags" />
                </div>

                <div class="mb-6">
                    <x-form.label for="privacy">Privacy</x-form.label>
                    <select id="privacy" name="privacy" class="field">
                        @foreach (\App\Enums\Privacy::cases() as $privacy)
                            <option
                                value="{{ $privacy->value }}"
                                @selected(old('privacy', 'private') === $privacy->value)
                            >
                                {{ $privacy->emoji() }} {{ $privacy->label() }}
                            </option>
                        @endforeach
                    </select>
                    <x-form.error name="privacy" />
                </div>

                <p data-offline-note class="mb-3 hidden text-center text-xs text-yellow-600 dark:text-yellow-400">
                    You're offline. Your entry will be saved on this device and synced when you're back online.
                </p>
                <x-button size="lg" type="submit" class="w-full">Save entry</x-button>
            </form>
        </x-card>
    </div>
@endsection
