@extends('layouts.app')
@section('title','Search Users on E-diary')

@push('meta')
    <link rel="canonical" href="https://ediary.shakiltech.com/search?q={{ request()->input('q', 'Users') }}" />
    <meta name="description" content="Search results for '{{ request()->input('q', 'Users') }}' on E-diary. Find profiles of users, view their follower counts, and explore their journals. Start connecting with others today!" />
    <meta name="keywords" content="E-diary search, user search, find users, connect with users, E-diary profiles, followers, online diary users, {{ request()->input('q', 'Users') }}" />
    <meta name="subject" content="Search Results for '{{ request()->input('q', 'Users') }}' on E-diary" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/search?q={{ request()->input('q', 'Users') }}" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/search?q={{ request()->input('q', 'Users') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Search Results | E-diary" />
    <meta name="twitter:description" content="Explore user profiles based on your search term. View followers, connect with people, and more on E-diary." />
    <meta name="twitter:image" content="https://ediary.shakiltech.com/icons/apple-icon-96x96.png" />
    <meta name="og:title" content="Search Results | E-diary" />
    <meta name="og:url" content="https://ediary.shakiltech.com/search?q={{ request()->input('q', 'Users') }}" />
    <meta name="og:image" content="https://ediary.shakiltech.com/icons/apple-icon-96x96.png" />
    <meta name="og:description" content="Discover users on E-diary based on the search term '{{ request()->input('q', 'Users') }}'. Connect and explore profiles, follower counts, and more." />

@endpush
@push('head')
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "SearchResultsPage",
        "mainEntity": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "/search?q={search_term_string}",
                "name": "Search Users"
            },
            "query": {
                "@type": "Text",
                "value": "{{ request()->input('q', 'Users') }}"
            }
        },
        "searchResult": [
            @foreach ($users as $user)
            {
                "@type": "Person",
                "name": "{{ $user->profile->name }}",
                "image": "{{ asset($user->profile->image) }}",
                "url": "{{ url("/user/$user->username") }}",
                "sameAs": "{{ url("/user/$user->username") }}",
                "followerCount": "{{ $user->profile->follower_count }}",
                "identifier": "{{ $user->id }}"
            } @if (!$loop->last),@endif
            @endforeach
        ]
        }
    </script>
@endpush

@section('content')
<section class="container max-w-screen-md mx-auto text-gray-900 dark:text-white p-4">
    <h1 class="font-semibold text-2xl search-result-title">Search Result for {{request()->input('q', 'Users')}}</h1>

    @forelse ($users as $user)
    @include('search._user')
    @empty
    <div class="rounded-md border flex p-2 items-center dark:bg-gray-900 dark:text-white">
        <p class="text-lg">No User Found.</p>
    </div>
    @endforelse

    @if ($users->count() > 0)
    {{$users->withQueryString()->links()}}
    @endif
</section>
@endsection
