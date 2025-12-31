@extends('layouts.app')
@section('title', 'Search Users on E-diary')

@push('meta')
    <link rel="canonical" href="{{ url('/search') }}?q={{ request('q') }}" />
    <meta name="description" content="Search results for '{{ request('q') }}' on E-diary. Find profiles of users, view their follower counts, and explore their journals." />
    <meta name="keywords" content="E-diary search, user search, find users, connect with users, E-diary profiles, {{ request('q') }}" />
    <meta property="og:title" content="Search Results | E-diary" />
    <meta property="og:url" content="{{ url('/search') }}?q={{ request('q') }}" />
    <meta property="og:description" content="Discover users on E-diary based on '{{ request('q') }}'. Connect and explore profiles." />
    <meta name="twitter:card" content="summary_large_image" />
@endpush

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "SearchResultsPage",
            "mainEntity": {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "/search?q={search_term_string}"
                },
                "query": "{{ request('q') }}"
            }
        }
    </script>
@endpush

@section('content')
    <div class="min-h-screen bg-linear-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 max-w-5xl">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Search Results
                </h1>

                <form action="{{ route('search') }}" method="GET" class="relative">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search for users..."
                            class="w-full pl-12 pr-4 py-4 text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm"
                            autofocus
                        />
                    </div>
                </form>

                @if(request('q'))
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        @if($users->total() > 0)
                            Found <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($users->total()) }}</span> {{ $users->total() === 1 ? 'user' : 'users' }} matching "<span class="font-medium">{{ request('q') }}</span>"
                        @endif
                    </p>
                @endif
            </div>

            <div class="space-y-4">
                @forelse ($users as $user)
                    <x-profile-search-caard :user="$user"/>
                @empty
                    <div class="text-center py-16 border rounded-xl border-gray-200 dark:border-gray-700">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-200 dark:bg-gray-700 mb-6">
                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Users Found</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                            We couldn't find any users matching your search. Try different keywords or browse all users.
                        </p>
                        <a href="{{ route('search') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                            Explore Users
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                @endforelse
            </div>

            @if($users->hasPages())
                <div class="mt-8">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
