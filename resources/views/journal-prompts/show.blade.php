@extends('layouts.app')

@php
    $url = url("journal-prompts/{$slug}");
    $count = collect($page['sections'])->flatten()->count();
    $date = \Illuminate\Support\Carbon::parse($page['date']);
    $related = collect($page['related'] ?? [])->mapWithKeys(fn (string $key) => [$key => config("journal-prompts.pages.{$key}")])->filter();
@endphp

@section('title', $page['headline'])
@section('description', $page['meta_description'])
@section('og_type', 'article')

@push('head')
    <script type="application/ld+json">
        {!!
            json_encode([
                '@@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'Article',
                        'headline' => $page['headline'],
                        'description' => $page['meta_description'],
                        'url' => $url,
                        'mainEntityOfPage' => $url,
                        'image' => asset('images/og/ediary.png'),
                        'datePublished' => $page['date'],
                        'dateModified' => $page['updated'] ?? $page['date'],
                        'author' => ['@type' => 'Person', 'name' => 'Shakil Alam', 'url' => 'https://github.com/itxshakil'],
                        'publisher' => ['@type' => 'Organization', 'name' => 'Ediary', 'url' => url('/'), 'logo' => ['@type' => 'ImageObject', 'url' => url('/icons/android-icon-192x192.png')]],
                    ],
                    [
                        '@type' => 'BreadcrumbList',
                        'itemListElement' => [
                            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Journal prompts', 'item' => url('journal-prompts')],
                            ['@type' => 'ListItem', 'position' => 2, 'name' => $page['title'], 'item' => $url],
                        ],
                    ],
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)
        !!}
    </script>
@endpush

@section('content')
    <div class="container mx-auto max-w-4xl px-4 py-12">
        <nav aria-label="Breadcrumb" class="mb-6 text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ url('journal-prompts') }}" class="hover:underline">Journal prompts</a>
            <span aria-hidden="true">/</span>
            <span>{{ $page['title'] }}</span>
        </nav>

        <article class="blog-card">
            <div class="blog-article-header">
                <span class="blog-badge blog-badge-purple mb-4">{{ $count }} prompts</span>
                <h1 class="mb-5 text-4xl leading-tight font-extrabold text-gray-900 md:text-5xl dark:text-white">
                    {{ $page['title'] }}
                </h1>
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-semibold text-gray-800 dark:text-gray-200">Shakil Alam</span>
                    <span class="h-1 w-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                    <time datetime="{{ $date->toDateString() }}">{{ $date->format('M j, Y') }}</time>
                </div>
            </div>

            <div class="blog-content px-6 py-12 md:p-12">
                @foreach ($page['intro'] as $paragraph)
                    <p @class(['text-xl leading-relaxed font-medium text-gray-600 md:text-2xl dark:text-gray-400' => $loop->first])>
                        {{ $paragraph }}
                    </p>
                @endforeach

                <p>
                    Each prompt below has a <strong>Write about this</strong> link: it opens a new private entry with
                    the prompt as its title, so you can start writing straight away.
                </p>

                @foreach ($page['sections'] as $heading => $prompts)
                    <h2>{{ $heading }}</h2>
                    <ul class="prompt-list">
                        @foreach ($prompts as $prompt)
                            <li>
                                <span class="min-w-0 flex-1 text-left">{{ $prompt }}</span>
                                <x-write-prompt-link :prompt="$prompt" />
                            </li>
                        @endforeach
                    </ul>
                @endforeach

                <h2>What an answer can look like</h2>
                <blockquote>{{ $page['example'] }}</blockquote>
                <p>That's it: a few honest lines. Nobody grades a diary.</p>

                <h2>Tips for using journal prompts</h2>
                <ul>
                    <li><strong>One prompt is enough.</strong> Answering a single prompt well beats skimming five.</li>
                    <li><strong>Set a small limit.</strong> Five minutes or three sentences keeps it easy to start.</li>
                    <li><strong>Be specific.</strong> Names, places and details make entries worth rereading.</li>
                    <li>
                        <strong>Keep it private.</strong> You write more honestly when you know nobody else will read
                        it. <a href="{{ url('security') }}">How Ediary keeps entries private</a>.
                    </li>
                </ul>

                @include('blogs._cta')

                @if ($related->isNotEmpty())
                    <div class="mt-16 border-t border-gray-100 pt-10 dark:border-gray-700/50">
                        <h3 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">More journal prompts</h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            @foreach ($related as $key => $other)
                                @include('journal-prompts._card', ['slug' => $key, 'page' => $other, 'heading' => 'h4'])
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </article>
    </div>
@endsection
