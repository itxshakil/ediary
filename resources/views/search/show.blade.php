@extends('layouts.app')
@section('title','Search')
@section('content')
<section class="container max-w-screen-md mt-4 mx-auto text-gray-900" id="user-section">
    <form action="/search" method="get" class="w-full text-right">
        <input
            class="w-48 m-1 px-3 py-2 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('q') border-red-500 @enderror"
            id="q" type="search" name="q" placeholder="Search user" autocomplete="off" required />
        @error('q')
        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
        @enderror
    </form>
    <h1 class="px-2 font-semibold text-2xl">Search Result for {{request()->input('q')}}</h1>
    <p class="px-2 text-lg mb-2">{{$users->total()}} results for {{request()->input('q')}}</p>

    @forelse ($users as $user)
    <div class="m-1 rounded border flex p-2 items-center">
        <img src="{{$user->profile->image}}" alt="Profile picture of {{$user->username}}"
            class="rounded-full h-24 w-24 border m-2">
        <div class="flex flex-col">
            <div class="text-xl">{{$user->profile->name}}</div>
            <div class="span text-lg">{{$user->username}}</div>
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