@extends('layouts.app')
@section('title', 'Your Entries')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Your entries</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Browse everything you've written, newest first.
                </p>
            </div>

            <x-button href="{{ route('diary.create') }}">
                <span>New entry</span>
            </x-button>
        </div>

        <div class="space-y-4">
            @forelse ($entries as $entry)
                <x-diary-card :entry="$entry" />
            @empty
                <div class="rounded-2xl border border-dashed border-gray-200 bg-white p-10 text-center text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    No diary entries yet. Start with your first one.
                </div>
            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
