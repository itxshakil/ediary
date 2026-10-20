@extends('layouts.app')
@section('title', 'Search people')

@section('robots', 'noindex, follow')

@push('meta')
    <link rel="canonical" href="{{ url('/search') }}" />
    <meta name="description" content="Find people who share their diary entries on Ediary." />
@endpush

@section('content')
    <div class="min-h-screen bg-linear-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <div class="container mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Search Results</h1>

                <form action="{{ route('search') }}" method="GET" class="relative">
                    <div class="relative">
                        <svg class="absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search for users..."
                            class="field pr-4 pl-12"
                            autofocus
                        />
                    </div>
                </form>

                @if (request('q'))
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        @if ($users->total() > 0)
                            Found
                            <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($users->total()) }}</span>
                            {{ $users->total() === 1 ? 'user' : 'users' }} matching "
                             class="font-medium">{{ request('q') }}</span
                            >"
                        @endif
                    </p>
                @endif
            </div>

            <div class="space-y-4">
                @forelse ($users as $user)
                    <x-profile-search-caard :user="$user" />
                @empty
                    <div class="rounded-xl border border-gray-200 py-16 text-center dark:border-gray-700">
                        <div class="mb-6 inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                            <svg class="h-10 w-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">No Users Found</h3>
                        <p class="mx-auto max-w-md text-gray-600 dark:text-gray-400">
                            We couldn't find any users matching your search. Try different keywords or browse all users.
                        </p>
                        <x-button size="lg" href="{{ route('search') }}" class="mt-6">
                            Explore Users
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </x-button>
                    </div>
                @endforelse
            </div>

            @if ($users->hasPages())
                <div class="mt-8">{{ $users->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection
