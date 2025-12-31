@extends('layouts.app')
@section('title','Frequently Asked Questions')

@push('meta')
    <link rel="canonical" href="{{ url('faq') }}" />
    <meta name="description" content="Find answers to the most common questions about E-diary. Learn how to create a diary, print entries, manage privacy, and more. Start journaling today!" />
    <meta name="keywords" content="E-diary FAQ, create a diary, print diary entries, privacy on E-diary, diary questions, online diary, E-diary help, diary support" />
    <meta name="subject" content="Frequently Asked Questions about E-diary" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/faq" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/faq" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Frequently Asked Questions | E-diary" />
    <meta name="twitter:description" content="Get answers to common questions about E-diary, including how to create a diary, manage privacy, and print your entries. Visit our support center for more info." />
    <meta name="twitter:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:title" content="Frequently Asked Questions | E-diary" />
    <meta name="og:url" content="https://ediary.shakiltech.com/faq" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:description" content="Find answers to common E-diary questions, from creating a diary to managing privacy and printing entries. Get started today!" />
@endpush

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "FAQPage",
            "name": "Frequently Asked Questions | E-diary",
            "headline": "Frequently Asked Questions about E-diary",
            "description": "Find answers to frequently asked questions about E-diary, including how to create a diary, print entries, manage privacy, and more.",
            "url": "https://ediary.shakiltech.com/faq",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "What is E-diary?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "E-diary is a free platform that helps you track your past, reflect on your present, and make predictions for the future. It allows you to document your life and relive memories with ease."
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
                        "text": "All entries in E-diary are encrypted. No one, including E-diary staff, can access your content without your login credentials."
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
    <div class="container mx-auto px-4 md:px-6 py-8 max-w-4xl">

        <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
            Frequently Asked Questions
        </h1>

        <p class="mt-3 text-sm md:text-base text-gray-700 dark:text-gray-300 hidden md:block leading-relaxed">
            Here are answers to the most common questions about E-diary.
            For more help, feel free to visit our support center.
        </p>

        <!-- FAQ: Q1 -->
        <h3 class="mt-8 text-lg font-semibold text-gray-900 dark:text-gray-200">
            What is E-diary?
        </h3>
        <p class="mt-2 ml-2 text-gray-700 dark:text-gray-300 leading-relaxed">
            E-diary is a <strong>free online diary platform</strong> that helps you document your life easily.
            Write notes from your phone, tablet, or laptop and revisit them anytime to see how you’ve grown.
            Whether it’s memories, predictions, or simple thoughts — E-diary keeps them safe and accessible.
        </p>

        <!-- FAQ: Q2 -->
        <h3 class="mt-8 text-lg font-semibold text-gray-900 dark:text-gray-200">
            How can I create a diary?
        </h3>
        <p class="mt-2 ml-2 text-gray-700 dark:text-gray-300 leading-relaxed">
            Just register with a username and password.
            <a href="/register" class="text-blue-700 dark:text-blue-400 underline underline-offset-2">
                Sign up here
            </a>
            and start writing instantly.
        </p>

        <!-- FAQ: Q3 -->
        <h3 class="mt-8 text-lg font-semibold text-gray-900 dark:text-gray-200">
            How can I print my entries?
        </h3>
        <p class="mt-2 ml-2 text-gray-700 dark:text-gray-300 leading-relaxed">
            Visit
            <a href="/request-data" class="text-blue-700 dark:text-blue-400 underline underline-offset-2">
                Request Data
            </a>
            to receive all your entries via email.
            You can unzip the file and print any entry you like.
            You may also print directly from your browser.
        </p>

        <!-- FAQ: Q4 -->
        <h3 class="mt-8 text-lg font-semibold text-gray-900 dark:text-gray-200">
            Who can see my entries?
        </h3>
        <p class="mt-2 ml-2 text-gray-700 dark:text-gray-300 leading-relaxed">
            All entries are private and visible only to you after you
            <a href="/login" class="text-blue-700 dark:text-blue-400 underline underline-offset-2">
                log in
            </a>.
            No one else can access your diary.
        </p>

        <!-- FAQ: Q5 -->
        <h3 class="mt-8 text-lg font-semibold text-gray-900 dark:text-gray-200">
            How does privacy work?
        </h3>
        <p class="mt-2 ml-2 text-gray-700 dark:text-gray-300 leading-relaxed">
            Privacy is our top priority.
            All your entries are stored in an <strong>encrypted</strong> format.
            Nothing is public by default, and no one (including staff) can read your content.
        </p>

        <!-- FAQ: Q6 -->
        <h3 class="mt-8 text-lg font-semibold text-gray-900 dark:text-gray-200">
            How did the idea come about?
        </h3>
        <p class="mt-2 ml-2 text-gray-700 dark:text-gray-300 leading-relaxed">
            E-diary was built from a love of journaling and revisiting past thoughts.
            With mobile devices always in our pockets, we wanted to create a way to:
        </p>

        <ol class="mt-3 ml-6 list-decimal space-y-1 text-gray-700 dark:text-gray-300">
            <li>Access your diary anytime, anywhere.</li>
            <li>Back up your diary safely without effort.</li>
            <li>Provide a fast, simple, modern journaling experience.</li>
        </ol>

        <!-- FAQ: Q7 -->
        <h3 class="mt-8 text-lg font-semibold text-gray-900 dark:text-gray-200">
            Why am I asked to give my email address?
        </h3>
        <p class="mt-2 ml-2 text-gray-700 dark:text-gray-300 leading-relaxed">
            Your email allows you to reset your password and helps us send your diary data when you request it.
        </p>

    </div>
@endsection
