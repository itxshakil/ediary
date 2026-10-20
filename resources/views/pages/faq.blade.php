@extends('layouts.app')
@section('title', 'Ediary FAQ: Privacy, Offline Writing and Your Entries')

@section('description', 'Answers to common questions about Ediary: who can see your entries, how privacy works, printing your diary, and why signup needs only an email.')

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "FAQPage",
            "name": "Frequently Asked Questions | Ediary",
            "headline": "Frequently Asked Questions about Ediary",
            "description": "Find answers to frequently asked questions about Ediary, including how to create a diary, print entries, manage privacy, and more.",
            "url": "https://ediary.shakiltech.com/faq",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "What is Ediary?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Ediary is a free platform that helps you track your past, reflect on your present, and make predictions for the future. It allows you to document your life and relive memories with ease."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How can I create a diary?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Simply register with a unique username and password. Once registered, you can immediately start writing diary entries."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How can I print my entries?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "To print your diary entries, request your data through the designated page. We will send all your entries to your email. You can unzip the file and print as needed."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Who can see my entries?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Your entries are private by default and can only be viewed by you after logging into your account."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How does privacy work?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "All entries in Ediary are encrypted at rest with AES-256, so a leaked database or backup does not expose readable entries. Entries are private by default, and we never sell your data or show ads. Our security page explains exactly how it works."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Why do I need to give my email address?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Your email is used for password recovery and also to send you your diary data when requested."
                    }
                }
            ]
        }
    </script>
@endpush

@section('content')
    <div class="bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="border-b border-gray-100 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
            <div class="container mx-auto px-4 py-16 text-center">
                <h1 class="mb-4 text-4xl font-extrabold text-gray-900 md:text-5xl dark:text-white">
                    Frequently Asked Questions
                </h1>
                <p class="mx-auto max-w-2xl text-xl text-gray-600 dark:text-gray-400">
                    Everything you need to know about Ediary. Can't find the answer you're looking for?
                    <a href="/contact" class="text-primary-600 dark:text-primary-400 hover:underline"
                        >Contact our support team</a
                    >.
                </p>
            </div>
        </div>

        <div class="container mx-auto max-w-4xl px-4 py-16">
            <div class="space-y-12">
                <!-- FAQ: Q1 -->
                <div class="group">
                    <h3 class="mb-4 flex items-center gap-3 text-2xl font-bold text-gray-900 dark:text-white">
                        <span class="bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 flex h-8 w-8 items-center justify-center rounded-xl text-sm">01</span>
                        What is Ediary?
                    </h3>
                    <div class="pl-11">
                        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
                            Ediary is a <strong>free online diary platform</strong> that helps you document your life
                            easily. Write notes from your phone, tablet, or laptop and revisit them anytime to see how
                            you’ve grown. Whether it’s memories, predictions, or simple thoughts — Ediary keeps them
                            safe and accessible.
                        </p>
                    </div>
                </div>

                <!-- FAQ: Q2 -->
                <div class="group">
                    <h3 class="mb-4 flex items-center gap-3 text-2xl font-bold text-gray-900 dark:text-white">
                        <span class="bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 flex h-8 w-8 items-center justify-center rounded-xl text-sm">02</span>
                        How can I create a diary?
                    </h3>
                    <div class="pl-11">
                        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
                            Just register with a username and password.
                            <a
                                href="/register"
                                class="text-primary-600 dark:text-primary-400 font-semibold hover:underline"
                            >Sign up here</a>
                            and start writing instantly. No complicated setup required.
                        </p>
                    </div>
                </div>

                <!-- FAQ: Q3 -->
                <div class="group">
                    <h3 class="mb-4 flex items-center gap-3 text-2xl font-bold text-gray-900 dark:text-white">
                        <span class="bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 flex h-8 w-8 items-center justify-center rounded-xl text-sm">03</span>
                        How can I print my entries?
                    </h3>
                    <div class="pl-11">
                        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
                            Visit the
                            <a
                                href="/request-data"
                                class="text-primary-600 dark:text-primary-400 font-semibold hover:underline"
                            >Request Data</a>
                            page to receive all your entries via email. You can unzip the file and print any entry you
                            like. You may also print directly from your browser using the system print dialog.
                        </p>
                    </div>
                </div>

                <!-- FAQ: Q4 -->
                <div class="group">
                    <h3 class="mb-4 flex items-center gap-3 text-2xl font-bold text-gray-900 dark:text-white">
                        <span class="bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 flex h-8 w-8 items-center justify-center rounded-xl text-sm">04</span>
                        Who can see my entries?
                    </h3>
                    <div class="pl-11">
                        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
                            All entries are private by default and visible only to you after you
                            <a
                                href="/login"
                                class="text-primary-600 dark:text-primary-400 font-semibold hover:underline"
                                >log in</a
                            >. We take your privacy seriously and ensure that your personal space remains truly yours.
                        </p>
                    </div>
                </div>

                <!-- FAQ: Q5 -->
                <div class="group">
                    <h3 class="mb-4 flex items-center gap-3 text-2xl font-bold text-gray-900 dark:text-white">
                        <span class="bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 flex h-8 w-8 items-center justify-center rounded-xl text-sm">05</span>
                        How does privacy work?
                    </h3>
                    <div class="pl-11">
                        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
                            Privacy is our top priority. All your entries are stored
                            <strong>encrypted at rest</strong> with AES-256. Nothing is public by default, we never sell
                            your data, and our
                            <a
                                href="{{ url('/security') }}"
                                class="text-primary-600 dark:text-primary-400 hover:underline"
                            >security page</a>
                            explains exactly how it works.
                        </p>
                    </div>
                </div>

                <!-- FAQ: Q6 -->
                <div class="group">
                    <h3 class="mb-4 flex items-center gap-3 text-2xl font-bold text-gray-900 dark:text-white">
                        <span class="bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 flex h-8 w-8 items-center justify-center rounded-xl text-sm">06</span>
                        Why am I asked for my email?
                    </h3>
                    <div class="pl-11">
                        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
                            Your email is used strictly for account-related purposes: password recovery and sending your
                            diary data when you request it. We value your inbox as much as your privacy.
                        </p>
                    </div>
                </div>
            </div>

            @include('blogs._cta')
        </div>
    </div>
@endsection
