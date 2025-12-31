@extends('layouts.app')
@section('title')
Latest Blog Article
@endsection

@push('meta')
    <link rel="canonical" href="{{ url('blog') }}" />
    <meta name="description" content="Discover how to start writing a diary and unlock creativity, self-expression, and inspiration. Read articles from top bloggers and experts on diary writing!" />
    <meta name="keywords" content="diary writing, how to write a diary, benefits of diary writing, journaling tips, personal diary, creative writing, self-expression, diary app" />
    <meta name="subject" content="Learn to Write a Diary and Explore Benefits of Journaling | E-Diary" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/blog" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/blog" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Discover Diary Writing Tips and Benefits – E-Diary Articles" />
    <meta name="twitter:description" content="Explore insightful articles on how to start a diary, the benefits of journaling, and expert tips to make the most of your writing." />
    <meta name="twitter:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:title" content="Diary Writing Tips and Benefits – Explore Expert Articles on E-Diary" />
    <meta name="og:url" content="https://ediary.shakiltech.com/blog" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:description" content="Learn how to write a diary, explore the benefits of journaling, and read articles from top bloggers and experts. Start your journaling journey today!" />
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
            "keywords": [
                "Diary Writing",
                "Journaling Tips",
                "Self-Expression"
            ]
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
            "keywords": [
                "Diary Benefits",
                "Creativity",
                "Self-Expression"
            ]
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
            "keywords": [
                "Starting a Diary",
                "Journaling Tips",
                "Writing Habit"
            ]
        }
    ]
}

    </script>

@endpush
@section('content')
    <div class="container mx-auto px-4 md:px-6">

        {{-- CTA --}}
        <div class="rounded-2xl bg-gray-200 dark:bg-gray-800
                p-5 text-center mt-4
                border border-gray-300/60 dark:border-gray-700/60
                shadow-sm">
            @auth
                <a
                    class="inline-block
                       bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                       text-white
                       px-4 py-2
                       rounded-xl
                       uppercase
                       shadow-sm hover:shadow-md
                       font-bold text-xs
                       transition"
                    href="/home">
                    Start writing Now
                </a>
            @else
                <a
                    class="inline-block
                       bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                       text-white
                       px-4 py-2
                       rounded-xl
                       uppercase
                       shadow-sm hover:shadow-md
                       font-bold text-xs
                       transition"
                    href="/login">
                    Start Writing now
                </a>
            @endauth
        </div>

        {{-- Heading --}}
        <h1 class="text-2xl font-bold underline px-4 py-6 text-gray-900 dark:text-white">
            Latest Articles
        </h1>

        {{-- Articles --}}
        <div class="flex flex-col md:flex-row gap-5 px-4 text-gray-900 dark:text-gray-100">

            <div class="w-full lg:w-1/2
                    bg-gray-200 dark:bg-gray-800
                    rounded-2xl
                    p-5
                    shadow-sm border border-gray-300/60 dark:border-gray-700/60">
                <h2 class="font-bold text-lg mb-1">
                    <a href="/blogs/goal-setting-for-success"
                       class="hover:underline">
                        5 Steps to Design the Life You’ve Always Dreamed Of
                    </a>
                </h2>
                <cite class="uppercase text-xs font-bold text-gray-600 dark:text-gray-400">
                    Written By
                </cite>
                <a class="uppercase text-xs font-bold text-gray-800 dark:text-gray-200 ml-1"
                   href="https://shakiltech.com">
                    Shakil Alam
                </a>
                <p class="mt-2 text-sm leading-relaxed">
                    Ready to turn your goals into achievements? Learn the best strategies for setting clear, actionable goals that lead to real success. Start planning your future today.
                    <a href="/blogs/goal-setting-for-success" class="text-blue-600 hover:underline">
                        read more...
                    </a>
                </p>
            </div>

            <div class="w-full lg:w-1/2
                    bg-gray-200 dark:bg-gray-800
                    rounded-2xl
                    p-5
                    shadow-sm border border-gray-300/60 dark:border-gray-700/60">
                <h2 class="font-bold text-lg mb-1">
                    <a href="/blogs/these-8-good-things-will-happen-when-you-start-writing-diary"
                       class="hover:underline">
                        These 8 Good Things Will Happen When You Start Writing Diaries
                    </a>
                </h2>
                <cite class="uppercase text-xs font-bold text-gray-600 dark:text-gray-400">
                    Written By
                </cite>
                <a class="uppercase text-xs font-bold text-gray-800 dark:text-gray-200 ml-1"
                   href="#">
                    INTERNET BLOGGER
                </a>
                <p class="mt-2 text-sm leading-relaxed">
                    Writing to yourself is an important means of self-expression. Whether you call it a diary or refer to it as a journal, having a place to write down your thoughts, feelings, memories and personal impressions about life can be healing and teach you to know yourself better. It can also unlock the power of your creativity, and inspire you to manifest dreams
                    <a href="/blogs/these-8-good-things-will-happen-when-you-start-writing-diary"
                       class="text-blue-600 hover:underline">
                        read more...
                    </a>
                </p>
            </div>

            <div class="w-full lg:w-1/2
                    bg-gray-200 dark:bg-gray-800
                    rounded-2xl
                    p-5
                    shadow-sm border border-gray-300/60 dark:border-gray-700/60">
                <h2 class="font-bold text-lg mb-1">
                    <a href="/blogs/how-to-start-writing-a-diary"
                       class="hover:underline">
                        How to Start Writing a Diary
                    </a>
                </h2>
                <cite class="uppercase text-xs font-bold text-gray-600 dark:text-gray-400">
                    Written By
                </cite>
                <a class="uppercase text-xs font-bold text-gray-800 dark:text-gray-200 ml-1"
                   href="https://shakiltech.com">
                    Shakil Alam
                </a>
                <p class="mt-2 text-sm leading-relaxed">
                    To start a diary, all you need is a willingness to write. Start by figuring out what you want to write in your journal.
                    If you aren’t sure, simply start writing and see where that leads.
                    <a href="/blogs/how-to-start-writing-a-diary"
                       class="text-blue-600 hover:underline">
                        read more...
                    </a>
                </p>
            </div>
        </div>

        {{-- CTA Bottom --}}
        <div class="rounded-2xl bg-gray-200 dark:bg-gray-800
                p-5 text-center my-6
                border border-gray-300/60 dark:border-gray-700/60
                shadow-sm">
            @auth
                <a class="inline-block bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                       text-white px-4 py-2 rounded-xl uppercase
                       shadow-sm hover:shadow-md font-bold text-xs transition"
                   href="/home">
                    Start writing Now
                </a>
            @else
                <a class="inline-block bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                       text-white px-4 py-2 rounded-xl uppercase
                       shadow-sm hover:shadow-md font-bold text-xs transition"
                   href="/login">
                    Start Writing now
                </a>
            @endauth
        </div>

        {{-- Related --}}
        <h3 class="text-xl font-bold underline px-4 py-4 text-gray-900 dark:text-white">
            Related Articles
        </h3>

        <div class="flex flex-col md:flex-row gap-5 px-4 text-gray-900 dark:text-gray-100">

            <div class="w-full lg:w-1/2
                    bg-gray-200 dark:bg-gray-800
                    rounded-2xl
                    p-5
                    shadow-sm border border-gray-300/60 dark:border-gray-700/60">
                <h2 class="font-bold text-lg mb-1">
                    <a href="/blogs/these-8-good-things-will-happen-when-you-start-writing-diary"
                       class="hover:underline">
                        These 8 Good Things Will Happen When You Start Writing Diaries
                    </a>
                </h2>
                <p class="mt-2 text-sm leading-relaxed">
                    Writing to yourself is an important means of self-expression. Whether you call it a diary or refer to it as a journal, having a place to write down your thoughts, feelings, memories and personal impressions about life can be healing and teach you to know yourself better.
                    <a href="/blogs/these-8-good-things-will-happen-when-you-start-writing-diary"
                       class="text-blue-600 hover:underline">
                        read more...
                    </a>
                </p>
            </div>

            <div class="w-full lg:w-1/2
                    bg-gray-200 dark:bg-gray-800
                    rounded-2xl
                    p-5
                    shadow-sm border border-gray-300/60 dark:border-gray-700/60">
                <h2 class="font-bold text-lg mb-1">
                    <a href="/blogs/how-to-start-writing-a-diary"
                       class="hover:underline">
                        How to Start Writing a Diary
                    </a>
                </h2>
                <p class="mt-2 text-sm leading-relaxed">
                    To start a diary, all you need is a willingness to write. Start by figuring out what you want to write in your journal.
                    <a href="/blogs/how-to-start-writing-a-diary"
                       class="text-blue-600 hover:underline">
                        read more...
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
