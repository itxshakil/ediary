@extends('layouts.app')
@section('title','Search Users on E-diary')
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
