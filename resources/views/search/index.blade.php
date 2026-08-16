@extends('layouts.app')
@section('content')
    <div class="container mx-auto max-w-7xl px-4 py-8">
        <div class="my-2 hidden" id="add-entry-form">
            <x-diary-form />
        </div>

        <x-search-component />

        <div class="space-y-4">
            @forelse ($entries as $entry)
                <x-diary-card :entry="$entry" />
            @empty
                <div class="relative overflow-hidden rounded-2xl border border-dashed border-gray-200 bg-linear-to-br from-gray-50 to-white p-10 text-center dark:border-gray-700 dark:from-gray-800 dark:to-gray-900">
                    <div class="absolute -top-10 -right-10 h-32 w-32 rounded-full bg-blue-500/10 blur-3xl"></div>

                    <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">No entries found</h3>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Nothing matched
                        <span class="font-medium text-gray-700 dark:text-gray-300"> “{{ request('q') }}” </span>
                    </p>

                    <p class="mx-auto mt-3 max-w-md text-sm text-gray-500 dark:text-gray-400">
                        Try a different keyword, or start a fresh diary entry while it’s still on your mind.
                    </p>

                    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <button
                            id="show-add-form"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                        >
                            ✍️ Write new entry
                        </button>

                        <a
                            href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800"
                        >
                            Clear search
                        </a>
                    </div>

            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('show-add-form');
            const form = document.getElementById('add-entry-form');

            if (btn && form) {
                btn.addEventListener('click', () => {
                    form.classList.remove('hidden');
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }
        });
    </script>
@endpush
