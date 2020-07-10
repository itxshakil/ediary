@extends('layouts.app')
@section('title','Search')
@section('content')
<section class="container max-w-screen-md mx-auto text-gray-900 p-4">
    <h1 class="font-semibold text-2xl">Search Result for {{request()->input('q')}}</h1>
    <p class="mb-2">{{$users->total()}} results for {{request()->input('q')}}</p>

    @forelse ($users as $user)
    <div class="my-1 p-2 rounded border flex items-center">
        <img src="{{$user->profile->image}}" alt="Profile picture of {{$user->username}}"
            class="rounded-full h-24 w-24 border mr-2">
        <div class="ml-3 flex flex-col">
            <h4 class="text-xl">{{$user->profile->name}}</h4>
            <p>{{$user->profile->follower_count}} Followers</p>
            <a href="/user/{{$user->username}}"
                class="bg-blue-600 text-gray-100 py-1 px-2 rounded outline-none focus:outline-none mt-2 uppercase shadow hover:shadow-md font-bold text-xs">View
                Profile</a>
        </div>
    </div>

    @empty
    <div class="rounded border flex p-2 items-center">
        <p class="text-lg">No User Found.</p>
    </div>
    @endforelse

    @if ($users->count() > 0)
    {{$users->appends(request()->input())->links('pagination.tailwind')}}
    @endif
</section>
@endsection