@extends('layouts.app')
@section('title', 'Journal Prompts: Free Ideas for What to Write')
@section('description', 'Free journal prompts for gratitude, mornings, evenings, self-reflection, goal setting and the New Year. Pick one and start writing in seconds.')

@section('content')
    <div class="container mx-auto max-w-7xl px-4 py-12">
        <div class="mb-16 text-center">
            <p class="text-primary-500 dark:text-primary-400 mb-3 text-xs font-semibold tracking-widest uppercase">
                Journal prompts
            </p>
            <h1 class="mb-5 text-4xl leading-tight font-extrabold text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                Journal prompts for when you don't know what to write
            </h1>
            <p class="mx-auto max-w-2xl text-lg leading-relaxed text-gray-500 dark:text-gray-400">
                Hand-picked prompts for every part of the day and every kind of week. Each one opens a new private entry
                in a click.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($pages as $slug => $page)
                @include('journal-prompts._card', ['slug' => $slug, 'page' => $page])
            @endforeach
            @include('blogs._card', ['slug' => 'journaling-prompts-for-students', 'post' => config('blog.posts.journaling-prompts-for-students')])
        </div>

        @include('blogs._cta')
    </div>
@endsection
