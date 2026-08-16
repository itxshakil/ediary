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
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org/",
            "@type": "Blog",
            "@id": "https://ediary.shakiltech.com/blog",
            "mainEntityOfPage": "https://ediary.shakiltech.com/blog",
            "name": "E-Diary Articles",
            "description": "Discover how to start writing a diary, unlock creativity, self-expression, and inspiration through insightful articles from expert writers.",
            "publisher": {
                "@type": "Organization",
                "@id": "https://ediary.shakiltech.com",
                "name": "E-Diary",
                "logo": {
                    "@type": "ImageObject",
                    "@id": "https://ediary.shakiltech.com/icons/android-icon-192x192.png",
                    "url": "https://ediary.shakiltech.com/icons/android-icon-192x192.png",
                    "width": "96",
                    "height": "96"
                }
            },
            "blogPost": [
                {
                    "@type": "BlogPosting",
                    "@id": "https://ediary.shakiltech.com/blogs/how-to-write-diary/#BlogPosting",
                    "mainEntityOfPage": "https://ediary.shakiltech.com/blogs/how-to-write-diary",
                    "headline": "How to Write a Diary",
                    "name": "How to Write a Diary",
                    "description": "Learn tips and tricks to get the most out of writing a diary. Explore ways to discuss emotions, record ideas, and reflect on life.",
                    "datePublished": "2023-01-01",
                    "dateModified": "2023-01-01",
                    "author": {
                        "@type": "Organization",
                        "@id": "https://ediary.shakiltech.com",
                        "name": "WikiHow"
                    },
                    "url": "https://ediary.shakiltech.com/blogs/how-to-write-diary",
                    "keywords": ["Diary Writing", "Journaling Tips", "Self-Expression"]
                },
                {
                    "@type": "BlogPosting",
                    "@id": "https://ediary.shakiltech.com/blogs/these-8-good-things-will-happen-when-you-start-writing-diary/#BlogPosting",
                    "mainEntityOfPage": "https://ediary.shakiltech.com/blogs/these-8-good-things-will-happen-when-you-start-writing-diary",
                    "headline": "These 8 Good Things Will Happen When You Start Writing Diaries",
                    "name": "These 8 Good Things Will Happen When You Start Writing Diaries",
                    "description": "Discover the amazing benefits of diary writing, including self-expression, creativity, and manifesting dreams.",
                    "datePublished": "2023-02-15",
                    "dateModified": "2023-02-15",
                    "author": {
                        "@type": "Person",
                        "@id": "https://ediary.shakiltech.com/author/internet-blogger/#Person",
                        "name": "Internet Blogger"
                    },
                    "url": "https://ediary.shakiltech.com/blogs/these-8-good-things-will-happen-when-you-start-writing-diary",
                    "keywords": ["Diary Benefits", "Creativity", "Self-Expression"]
                },
                {
                    "@type": "BlogPosting",
                    "@id": "https://ediary.shakiltech.com/blogs/how-to-start-writing-a-diary/#BlogPosting",
                    "mainEntityOfPage": "https://ediary.shakiltech.com/blogs/how-to-start-writing-a-diary",
                    "headline": "How to Start Writing a Diary",
                    "name": "How to Start Writing a Diary",
                    "description": "Learn how to begin your journaling journey. Find tips for starting your diary and making writing a daily habit.",
                    "datePublished": "2023-03-01",
                    "dateModified": "2023-03-01",
                    "author": {
                        "@type": "Person",
                        "@id": "https://ediary.shakiltech.com/author/shakil-alam/#Person",
                        "name": "Shakil Alam"
                    },
                    "url": "https://ediary.shakiltech.com/blogs/how-to-start-writing-a-diary",
                    "keywords": ["Starting a Diary", "Journaling Tips", "Writing Habit"]
                }
            ]
        }
    </script>

@endpush
@section('content')
    <div class="container mx-auto max-w-7xl px-4 py-12">
        {{-- Hero --}}
        <div class="mb-16 text-center">
            <p class="mb-3 text-xs font-semibold tracking-widest text-blue-500 uppercase dark:text-blue-400">
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
            {{-- Article 1 --}}
            <div class="blog-card group">
                <div class="blog-card-body">
                    <span class="blog-badge blog-badge-blue">Goal Setting</span>
                    <h2 class="blog-card-title">
                        <a href="/blogs/goal-setting-for-success">
                            5 Steps to Design the Life You’ve Always Dreamed Of
                        </a>
                    </h2>
                    <p class="blog-card-excerpt">
                        Ready to turn your goals into achievements? Learn the best strategies for setting clear,
                        actionable goals that lead to real success.
                    </p>
                </div>
                <div class="blog-card-footer">
                    <div class="blog-card-author">
                        <span class="blog-card-author-label">Written By</span>
                        <a class="blog-card-author-name" href="https://shakiltech.com">Shakil Alam</a>
                    </div>
                    <a href="/blogs/goal-setting-for-success" class="blog-card-arrow" aria-label="Read article">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>

            {{-- Article 2 --}}
            <div class="blog-card group">
                <div class="blog-card-body">
                    <span class="blog-badge blog-badge-purple">Benefits</span>
                    <h2 class="blog-card-title">
                        <a href="/blogs/these-8-good-things-will-happen-when-you-start-writing-diary">
                            8 Good Things That Happen When You Start Journaling
                        </a>
                    </h2>
                    <p class="blog-card-excerpt">
                        Writing to yourself is an important means of self-expression. Discover how a diary can be
                        healing, unlock creativity, and help you know yourself better.
                    </p>
                </div>
                <div class="blog-card-footer">
                    <div class="blog-card-author">
                        <span class="blog-card-author-label">Written By</span>
                        <span class="blog-card-author-name">Internet Blogger</span>
                    </div>
                    <a
                        href="/blogs/these-8-good-things-will-happen-when-you-start-writing-diary"
                        class="blog-card-arrow"
                        aria-label="Read article"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>

            {{-- Article 3 --}}
            <div class="blog-card group">
                <div class="blog-card-body">
                    <span class="blog-badge blog-badge-green">Getting Started</span>
                    <h2 class="blog-card-title">
                        <a href="/blogs/how-to-start-writing-a-diary"> How to Start Writing a Diary </a>
                    </h2>
                    <p class="blog-card-excerpt">
                        To start a diary, all you need is a willingness to write. Learn how to figure out what you want
                        to write and how to make it a daily habit.
                    </p>
                </div>
                <div class="blog-card-footer">
                    <div class="blog-card-author">
                        <span class="blog-card-author-label">Written By</span>
                        <a class="blog-card-author-name" href="https://shakiltech.com">Shakil Alam</a>
                    </div>
                    <a href="/blogs/how-to-start-writing-a-diary" class="blog-card-arrow" aria-label="Read article">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>
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
                        class="flex items-center gap-1 text-sm font-semibold text-blue-600 hover:underline dark:text-blue-400"
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
                        class="flex items-center gap-1 text-sm font-semibold text-blue-600 hover:underline dark:text-blue-400"
                    >
                        Read Our Story
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
