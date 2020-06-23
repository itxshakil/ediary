@extends('layouts.app')
@section('title','Search')
@section('content')
<section class="container max-w-screen-md mt-4 mx-auto text-gray-900" id="user-section">
    <h1 class="px-2 font-semibold text-2xl">Search Result for {{request()->input('q')}}</h1>
    <p class="px-2 text-lg mb-2">{{$users->total()}} results for {{request()->input('q')}}</p>

    @forelse ($users as $user)
    <div class="m-1 rounded border flex p-2 items-center">
        <img src="{{$user->profile->image}}" alt="Profile picture of {{$user->username}}"
            class="rounded-full h-24 w-24 border m-2">
        <div class="ml-3 flex flex-col">
            <div class="text-xl">{{$user->profile->name}}</div>
            <div class="span">{{$user->profile->follower_count}} Followers</div>
            <a href="/user/{{$user->username}}"
                class="bg-blue-600 text-gray-100 font-normal px-2 py-1 rounded outline-none focus:outline-none mr-2 my-2 uppercase shadow hover:shadow-md font-bold text-xs">View
                Profile</a>
        </div>
    </div>

    @empty
    <div class="m-1 rounded border flex p-2 items-center">
        <p class="text-lg">No User Found.</p>
    </div>
    @endforelse

    @if ($users->count() > 0)
    {{$users->appends(request()->input())->links('pagination.tailwind   ')}}
    @endif
</section>
@endsection