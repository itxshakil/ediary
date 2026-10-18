@extends('layouts.app')
@section('title', $mood->label() . ' Entries')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">
                    <span aria-hidden="true">{{ $mood->emoji() }}</span>
                    {{ $mood->label() }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ trans_choice('{1} 1 entry|[0,*] :count entries', $entries->total()) }} where you felt {{ strtolower($mood->label()) }},
                    newest first.
                </p>
            </div>

            <a
                href="{{ url('/diaries') }}"
                class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
            >
                <span>All entries</span>
            </a>
        </div>

        <div class="space-y-4">
            @forelse ($entries as $entry)
                <x-diary-card :entry="$entry" />
            @empty
                <div class="rounded-2xl border border-dashed border-gray-200 bg-white p-10 text-center text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    No entries with this mood yet.
                </div>
            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
