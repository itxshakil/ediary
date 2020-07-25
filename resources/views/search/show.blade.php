@extends('layouts.app')
@section('title','Search')
@section('content')
<section class="container max-w-screen-md mx-auto text-gray-900 p-4">
    <h1 class="font-semibold text-2xl">Search Result for {{request()->input('q')}}</h1>
    <p class="mb-2">{{$users->total()}} results for {{request()->input('q')}}</p>

    @forelse ($users as $user)
    @include('search._user')
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