@extends('layouts.app')
@section('title')
    Latest Blog Article
@endsection

@push('meta')
    <link rel="canonical" href="{{ url('blog') }}" />
    <meta
        name="description"
        content="Discover how to start writing a diary and unlock creativity, self-expression, and inspiration. Read articles from top bloggers and experts on diary writing!"
    />
    <meta
        name="keywords"
        content="diary writing, how to write a diary, benefits of diary writing, journaling tips, personal diary, creative writing, self-expression, diary app"
    />
    <meta name="subject" content="Learn to Write a Diary and Explore Benefits of Journaling | E-Diary" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/blog" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/blog" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Discover Diary Writing Tips and Benefits – E-Diary Articles" />
    <meta
        name="twitter:description"
        content="Explore insightful articles on how to start a diary, the benefits of journaling, and expert tips to make the most of your writing."
    />
    <meta name="twitter:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:title" content="Diary Writing Tips and Benefits – Explore Expert Articles on E-Diary" />
    <meta name="og:url" content="https://ediary.shakiltech.com/blog" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta
        name="og:description"
        content="Learn how to write a diary, explore the benefits of journaling, and read articles from top bloggers and experts. Start your journaling journey today!"
    />
@endpush

@push('head')
    @php
        $posts = config('blog.posts');
    @endphp
    <script type="application/ld+json">
        {!!
            json_encode([
                '@context' => 'https://schema.org/',
                '@type' => 'Blog',
                '@id' => url('blog'),
                'mainEntityOfPage' => url('blog'),
                'name' => 'E-Diary Articles',
                'description' => 'Articles on starting and keeping a diary, journaling for students and researchers, and choosing a private journal.',
                'publisher' => [
                    '@type' => 'Organization',
                    '@id' => url('/'),
                    'name' => 'E-Diary',
                    'logo' => ['@type' => 'ImageObject', 'url' => url('/icons/android-icon-192x192.png')],
                ],
                'blogPost' => collect($posts)->map(fn (array $post, string $slug) => [
                    '@type' => 'BlogPosting',
                    '@id' => url("blogs/{$slug}") . '#BlogPosting',
                    'mainEntityOfPage' => url("blogs/{$slug}"),
                    'headline' => $post['headline'] ?? $post['title'],
                    'description' => $post['description'],
                    'datePublished' => $post['date'],
                    'author' => ['@type' => 'Person', 'name' => $post['author']],
                    'url' => url("blogs/{$slug}"),
                    'keywords' => $post['keywords'] ?? [],
                ])->values(),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)
        !!}
    </script>
@endpush
@section('content')
    <div class="container mx-auto max-w-7xl px-4 py-12">
        {{-- Hero --}}
        <div class="mb-16 text-center">
            <p class="text-primary-500 dark:text-primary-400 mb-3 text-xs font-semibold tracking-widest uppercase">
                E-Diary Journal
            </p>
            <h1 class="mb-5 text-4xl leading-tight font-extrabold text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                Latest Articles
            </h1>
            <p class="mx-auto max-w-xl text-lg leading-relaxed text-gray-500 dark:text-gray-400">
                Discover tips and insights on journaling, personal growth, and documenting your life journey.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach (config('blog.posts') as $slug => $post)
                @continue(! ($post['listed'] ?? true))
                <div class="blog-card group">
                    <div class="blog-card-body">
                        <span class="blog-badge blog-badge-{{ $post['badge_color'] ?? 'blue' }}">{{ $post['badge'] }}</span>
                        <h2 class="blog-card-title">
                            <a href="{{ url("blogs/{$slug}") }}">{{ $post['title'] }}</a>
                        </h2>
                        <p class="blog-card-excerpt">{{ $post['description'] }}</p>
                    </div>
                    <div class="blog-card-footer">
                        <div class="blog-card-author">
                            <span class="blog-card-author-label">Written By</span>
                            <span class="blog-card-author-name">{{ $post['author'] }}</span>
                        </div>
                        <a
                            href="{{ url("blogs/{$slug}") }}"
                            class="blog-card-arrow"
                            aria-label="Read {{ $post['title'] }}"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @include('blogs._cta')

        <div class="mt-20">
            <h3 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Journaling Resources</h3>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <div class="group rounded-2xl bg-gray-100 p-6 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <h4 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">
                        <a href="/faq">Common Questions (FAQ)</a>
                    </h4>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        Everything you need to know about privacy, security, and how to use Ediary effectively.
                    </p>
                    <a
                        href="/faq"
                        class="text-primary-600 dark:text-primary-400 flex items-center gap-1 text-sm font-semibold hover:underline"
                    >
                        View FAQ
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="group rounded-2xl bg-gray-100 p-6 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <h4 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">
                        <a href="/about">Our Mission</a>
                    </h4>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        Learn why we built Ediary and our commitment to providing a safe space for your thoughts.
                    </p>
                    <a
                        href="/about"
                        class="text-primary-600 dark:text-primary-400 flex items-center gap-1 text-sm font-semibold hover:underline"
                    >
                        Read Our Story
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
