{{-- Article layout for posts in config/blog.php; $post comes from the route. Posts only provide @section('article'). --}}
@extends('layouts.app')

@php
    $url = url("blogs/{$post['slug']}");
    $headline = $post['headline'] ?? $post['title'];
    $date = \Illuminate\Support\Carbon::parse($post['date']);
@endphp

@section('title', $headline)
@section('og_type', 'article')

@section('description', $post['meta_description'] ?? $post['description'])

@push('head')
    <script type="application/ld+json">
        {!!
            json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $headline,
                'description' => $post['description'],
                'url' => $url,
                'mainEntityOfPage' => $url,
                'image' => asset('images/og/ediary.png'),
                'datePublished' => $post['date'],
                'dateModified' => $post['updated'] ?? $post['date'],
                'author' => ['@type' => 'Person', 'name' => $post['author'], 'url' => url('/')],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'Ediary',
                    'url' => url('/'),
                    'logo' => ['@type' => 'ImageObject', 'url' => url('/icons/android-icon-192x192.png')],
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)
        !!}
    </script>
@endpush

@section('content')
    <div class="container mx-auto max-w-4xl px-4 py-12">
        <article class="blog-card">
            <div class="blog-article-header">
                <span class="blog-badge blog-badge-{{ $post['badge_color'] ?? 'blue' }} mb-4">{{ $post['badge'] }}</span>
                <h1 class="mb-5 text-4xl leading-tight font-extrabold text-gray-900 md:text-5xl dark:text-white">
                    {{ $post['title'] }}
                </h1>
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $post['author'] }}</span>
                    <span class="h-1 w-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                    <time datetime="{{ $date->toDateString() }}">{{ $date->format('M j, Y') }}</time>
                    @isset($post['minutes'])
                        <span class="h-1 w-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                        <span>{{ $post['minutes'] }} min read</span>
                    @endisset
                </div>
            </div>

            <div class="blog-content px-6 py-12 md:p-12">
                @yield('article')

                @include('blogs._cta')

                @include('blogs._related')
            </div>
        </article>
    </div>
@endsection
