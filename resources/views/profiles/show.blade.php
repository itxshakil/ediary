@extends('layouts.app')
@section('title')
{{$profile->name}} 's Profile Page
@endsection

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "{{ $profile->name }}",
  "description": "{{ $profile->bio }}",
  "url": "{{ url()->current() }}",
  "image": "{{ $profile->image }}",
  "sameAs": [
    "{{ url()->current() }}"
  ]
}
</script>
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
