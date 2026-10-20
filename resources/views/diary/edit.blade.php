@extends('layouts.app')
@section('title', 'Edit entry')
@section('robots', 'noindex, nofollow')
@section('content')
    <div class="container mx-auto max-w-2xl px-4 py-8">
        <x-page-header title="Edit entry" :subtitle="'Written ' . $entry->created_at->format('j M Y')" />

        <x-card>
            <form method="POST" action="{{ route('diary.update', $entry) }}" data-entry-form="edit" data-warn-unsaved>
                @csrf
                @method('PUT')

                @include('diary._fields', ['entry' => $entry])

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <x-button variant="secondary" size="lg" href="{{ route('home') }}">Cancel</x-button>
                    <x-button size="lg" type="submit">Save changes</x-button>
                </div>
            </form>
        </x-card>

        {{-- Two steps instead of a confirm() dialog: open the panel, then confirm. --}}
        <details class="mt-6 rounded-2xl border border-red-200 p-4 dark:border-red-900/60">
            <summary class="cursor-pointer text-sm font-semibold text-red-600 dark:text-red-400">
                Delete this entry
            </summary>
            <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                This removes the entry, its tags, likes and comments for good. It can't be undone.
            </p>
            <form method="POST" action="{{ route('diary.destroy', $entry) }}" class="mt-4">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit">Yes, delete this entry</x-button>
            </form>
        </details>
    </div>
@endsection
