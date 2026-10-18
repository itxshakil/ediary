@extends('layouts.app')
@section('title', 'Private Study Journal for Students & Researchers')
@push('meta')
    <link rel="canonical" href="{{ url('for-students') }}" />
    <meta
        name="description"
        content="A free, private journal for students and researchers. Keep study logs, research reflections, and exam-stress notes. Unlimited entries, works offline, email-only signup."
    />
    <meta
        name="keywords"
        content="journal for students, study journal, research journal, PhD reflective journal, private study notes, offline journal app, reflective journal university"
    />
    <meta name="subject" content="E-diary for students and researchers" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="og:title" content="E-diary - A Private Study Journal That Works Offline" />
    <meta name="og:url" content="{{ url('for-students') }}" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta
        name="og:description"
        content="Study logs, research reflections, and exam-stress notes in one private journal. Free, unlimited, and it works offline."
    />
@endpush

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "Is E-diary free for students?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes. E-diary is free with unlimited entries. You only need an email address to sign up."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I write without an internet connection?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes. Entries you write offline are kept on your device and sync automatically when you are back online."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can my university, classmates, or supervisor see my entries?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "No. Every entry is private by default. Nobody else can see an entry unless you choose to share it."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I get my notes out if I need them for a thesis or report?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes. You can export all of your entries at any time."
                    }
                }
            ]
        }
    </script>
@endpush

@section('content')
    <div class="bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-blue-600 py-20">
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute inset-0"
                    style="
                        background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0);
                        background-size: 40px 40px;
                    "
                ></div>
            </div>
            <div class="relative container mx-auto px-4 text-center">
                <p class="mb-4 text-sm font-semibold tracking-wider text-blue-200 uppercase">
                    For students & researchers
                </p>
                <h1 class="mb-6 text-4xl font-extrabold text-white md:text-6xl">
                    A private study journal that works offline
                </h1>
                <p class="mx-auto mb-10 max-w-2xl text-xl text-blue-100">
                    Log what you studied, reflect on your research, and get exam stress out of your head. Free,
                    unlimited, and private by default.
                </p>
                @auth
                    <a
                        href="{{ url('/home') }}"
                        class="inline-block rounded-xl bg-white px-8 py-3 text-sm font-bold text-blue-700 uppercase shadow-md transition hover:bg-blue-50"
                    >
                        Start writing
                    </a>
                @else
                    <a
                        href="{{ route('register') }}"
                        class="inline-block rounded-xl bg-white px-8 py-3 text-sm font-bold text-blue-700 uppercase shadow-md transition hover:bg-blue-50"
                    >
                        Create your free journal
                    </a>
                    <p class="mt-4 text-sm text-blue-200">Just an email. No name, no phone number.</p>
                @endauth
            </div>
        </div>

        <!-- Use Cases -->
        <div class="container mx-auto max-w-5xl px-4 py-16">
            <h2 class="mb-10 text-center text-3xl font-bold text-gray-900 dark:text-white">What students use it for</h2>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">Study logs</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Write down what you covered, what clicked, and what to revisit. Tag entries by course so
                        revision week starts with a map instead of a blank page.
                    </p>
                </div>
                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">Research reflections</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Keep a running research diary: decisions, dead ends, and half-formed ideas. It becomes the raw
                        material for your methods chapter and supervisor meetings.
                    </p>
                </div>
                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">Exam stress</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Track your mood alongside your study days and spot the patterns. Writing worries down is a
                        simple way to clear your head before an exam.
                    </p>
                </div>
            </div>
        </div>

        <!-- Why E-diary -->
        <div class="bg-gray-50 py-16 dark:bg-gray-800/50">
            <div class="container mx-auto max-w-4xl px-4">
                <h2 class="mb-10 text-center text-3xl font-bold text-gray-900 dark:text-white">Why E-diary</h2>
                <ul class="grid gap-6 text-gray-700 md:grid-cols-2 dark:text-gray-300">
                    <li>
                        <strong class="text-gray-900 dark:text-white">Works offline.</strong>
                        Write in the library, on the train, or anywhere with bad Wi-Fi. Entries sync when you reconnect.
                    </li>
                    <li>
                        <strong class="text-gray-900 dark:text-white">Unlimited and free.</strong>
                        No entry limits and no storage caps, so a long research diary never hits a paywall.
                    </li>
                    <li>
                        <strong class="text-gray-900 dark:text-white">Private by default.</strong>
                        Entries are encrypted at rest and only visible to you unless you choose to share one.
                    </li>
                    <li>
                        <strong class="text-gray-900 dark:text-white">Tags, search, and stats.</strong>
                        Find any note by course or keyword, and see your writing streaks and mood trends.
                    </li>
                    <li>
                        <strong class="text-gray-900 dark:text-white">Install it like an app.</strong>
                        Add E-diary to your phone or laptop home screen. No app store needed.
                    </li>
                    <li>
                        <strong class="text-gray-900 dark:text-white">Your notes stay yours.</strong>
                        Export everything at any time. Read
                        <a href="{{ url('/security') }}" class="text-blue-600 hover:underline dark:text-blue-400"
                            >how we protect your data</a
                        >.
                    </li>
                </ul>
            </div>
        </div>

        <!-- How to start -->
        <div class="container mx-auto max-w-4xl px-4 py-16">
            <h2 class="mb-10 text-center text-3xl font-bold text-gray-900 dark:text-white">Start in under a minute</h2>
            <ol class="grid gap-8 md:grid-cols-3">
                <li class="text-center">
                    <span class="mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">1</span>
                    <p class="text-gray-700 dark:text-gray-300">Sign up with your email address.</p>
                </li>
                <li class="text-center">
                    <span class="mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">2</span>
                    <p class="text-gray-700 dark:text-gray-300">Write your first entry: what did you study today?</p>
                </li>
                <li class="text-center">
                    <span class="mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">3</span>
                    <p class="text-gray-700 dark:text-gray-300">
                        Add a course tag so you can find it again at revision time.
                    </p>
                </li>
            </ol>
        </div>

        <!-- Guides -->
        <div class="bg-gray-50 py-16 dark:bg-gray-800/50">
            <div class="container mx-auto max-w-4xl px-4">
                <h2 class="mb-8 text-center text-3xl font-bold text-gray-900 dark:text-white">
                    Guides to get you started
                </h2>
                <ul class="grid gap-4 md:grid-cols-3">
                    <li>
                        <a
                            href="/blogs/how-to-keep-a-study-journal"
                            class="block h-full rounded-2xl border border-gray-100 bg-white p-6 transition hover:shadow-md dark:border-gray-700 dark:bg-gray-800"
                        >
                            <span class="mb-2 block font-bold text-gray-900 dark:text-white">How to keep a study journal</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">A five-minute template for after every study session.</span>
                        </a>
                    </li>
                    <li>
                        <a
                            href="/blogs/how-to-keep-a-research-journal"
                            class="block h-full rounded-2xl border border-gray-100 bg-white p-6 transition hover:shadow-md dark:border-gray-700 dark:bg-gray-800"
                        >
                            <span class="mb-2 block font-bold text-gray-900 dark:text-white">How to keep a research journal</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Record decisions and dead ends for your thesis.</span>
                        </a>
                    </li>
                    <li>
                        <a
                            href="/blogs/journaling-prompts-for-students"
                            class="block h-full rounded-2xl border border-gray-100 bg-white p-6 transition hover:shadow-md dark:border-gray-700 dark:bg-gray-800"
                        >
                            <span class="mb-2 block font-bold text-gray-900 dark:text-white">40 journaling prompts for students</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">For study reflection, exam stress, and more.</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- FAQ -->
        <div class="container mx-auto max-w-3xl px-4 pb-16">
            <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Questions</h2>
            <div class="space-y-8 text-gray-700 dark:text-gray-300">
                <div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Is E-diary free for students?</h3>
                    <p>Yes. E-diary is free with unlimited entries. You only need an email address to sign up.</p>
                </div>
                <div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Can I write without an internet connection?
                    </h3>
                    <p>
                        Yes. Entries you write offline are kept on your device and sync automatically when you are back
                        online.
                    </p>
                </div>
                <div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Can my university, classmates, or supervisor see my entries?
                    </h3>
                    <p>
                        No. Every entry is private by default. Nobody else can see an entry unless you choose to share
                        it.
                    </p>
                </div>
                <div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Can I get my notes out if I need them for a thesis or report?
                    </h3>
                    <p>Yes. You can export all of your entries at any time.</p>
                </div>
            </div>

            @include('blogs._cta')
        </div>
    </div>
@endsection
