@extends('layouts.app')
@section('title', '#' . $tag . ' Entries')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">#{{ $tag }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ trans_choice('{1} 1 entry tagged #:tag|[0,*] :count entries tagged #:tag', $entries->total(), ['tag' => $tag]) }},
                    newest first.
                </p>
            </div>

            <x-button variant="secondary" href="{{ url('/diaries') }}">
                <span>All entries</span>
            </x-button>
        </div>

        <div class="space-y-4">
            @forelse ($entries as $entry)
                <x-diary-card :entry="$entry" />
            @empty
                <div class="rounded-2xl border border-dashed border-gray-200 bg-white p-10 text-center text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    No entries with this tag yet.
                </div>
            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
