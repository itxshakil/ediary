@extends('layouts.app')
@section('title')
{{$profile->name}} 's Profile Page
@endsection

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfilePage",
  "dateCreated": "2024-12-23T12:34:00-05:00",
  "dateModified": "2024-12-26T14:53:00-05:00",
  "mainEntity": {
    "@type": "Person",
    "name": "{{ $profile->name }}",
    "alternateName": "{{ $profile->username }}",
    "identifier": "{{ $profile->id }}",
    "interactionStatistic": [
      {
        "@type": "InteractionCounter",
        "interactionType": "https://schema.org/FollowAction",
        "userInteractionCount": "{{ $profile->follower_count }}"
      },
      {
        "@type": "InteractionCounter",
        "interactionType": "https://schema.org/LikeAction",
        "userInteractionCount": "{{ $profile->like_count }}"
      }
    ],
    "agentInteractionStatistic": {
      "@type": "InteractionCounter",
      "interactionType": "https://schema.org/WriteAction",
      "userInteractionCount": "{{ $profile->post_count }}"
    },
    "description": "{{ $profile->bio }}",
    "image": "{{ $profile->image }}",
    "sameAs": [
      "{{ url()->current() }}",
      "https://www.example.com/{{ $profile->username }}"
    ]
  }
}

</script>
@endpush

@push('meta')
    <meta name="description" content="{{ $profile->name }}'s profile - {{ $profile->bio }}" />
    <meta name="keywords" content="user, profile, diary, Ediary" />
    <meta name="subject" content="{{ $profile->name }}'s Profile" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="{{ request()->fullUrl() }}" />
    <meta name="identifier-URL" content="{{ request()->fullUrl() }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="{{ $profile->name }}'s Profile" />
    <meta name="twitter:creator" content="@itxshakil" />
    <meta name="og:title" content="{{ $profile->name }}'s Profile" />
    <meta name="og:url" content="{{ request()->fullUrl() }}" />
    <meta name="og:image" content="{{ $profile->image }}" />
    <meta name="og:description" content="{{ $profile->name }}'s Profile - {{ $profile->bio }}" />
@endpush

@section('content')
<div class="container mx-auto px-3 md:px-6">
    <h1 class="text-xl">{{ $profile->name }}'s Profile</h1>
    <div class="text-gray-900 flex justify-center items-center mt-4">
        @can('update', $profile)
        <profile :data="{{$profile->toJson()}}" :can-edit="true"></profile>
        @else
        <profile :data="{{$profile->toJson()}}" :can-edit="false" :is-following="{{$isFollowing ? "true" :"false" }}">
        </profile>
        @endcan
    </div>
    <div class="text-gray-900 flex justify-center items-center mt-4 h-full">
        <div class="w-full h-auto bg-gray-200 dark:bg-gray-800 dark:text-white lg:block lg:w-1/2 bg-cover rounded-lg py-4 p-2 md:p-8">
            <div class="flex justify-between flex-wrap">
                <p class="font-semibold">Public posts</p>
                <a href="/contact" class="text-xs uppercase text-blue-700">Send suggestions</a>
            </div>
            <p class="text-center text-4xl my-12">Coming soon</p>
        </div>
    </div>
</div>
@endsection
