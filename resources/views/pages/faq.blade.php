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
        "@context": "https://schema.org",
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
                "text": "E-diary is a free service that helps you track your past, make predictions for the future, and see how you change over time. It allows you to document your life and relive memories with ease."
            }
            },
            {
            "@type": "Question",
            "name": "How can I create a diary?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "To create a diary, you simply need to register with a unique username and password. Once registered, you can start documenting your thoughts."
            }
            },
            {
            "@type": "Question",
            "name": "How can I print my entries?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "You can request your diary entries by visiting the designated page, and we'll send them to your email. You can then unzip and print them as you wish."
            }
            },
            {
            "@type": "Question",
            "name": "Who can see my entries?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Your entries are private by default. Only you can access and view your diary entries after logging into your account."
            }
            },
            {
            "@type": "Question",
            "name": "How does privacy work?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "E-diary ensures your privacy by encrypting all your entries. No one, including E-diary staff, can access your content without your login credentials."
            }
            },
            {
            "@type": "Question",
            "name": "Why do I need to give my email address?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "We ask for your email address to help you reset your password if necessary. It’s also used to send you your diary data upon request."
            }
            }
        ],
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "reviewCount": "150",
            "bestRating": "5",
            "worstRating": "1"
        }
        }
    </script>
@endpush

@section('content')
<div class="container mx-auto px-3 md:px-6">
    <h1 class="text-xl md:text-2xl mt-4">Frequently Asked Questions and Answers:</h1>
    <p class="hidden md:block">This is a shortlist of our most frequently asked questions. For more information about
        E-diary, or if you need support, please visit our support center. </p>

    <h3 class="font-semibold mt-4">What is E-diary?</h3>
    <p class="ml-2 mb-2">E-diary is a <strong>free</strong> service to keep track of your past and think about your
        future. You can make predictions about what will happen and see if they come true, and you can see how you
        changed over time, and read over memories, having a few laughs. It's the funniest, quickest, and easiest way to document your life
        through a series of notes. Tap down a note or a thought on your notebook, mobile phone, or tablet and transform
        it into a memory to keep around forever. </p>

    <h3 class="font-semibold mt-4">How can I create a diary?</h3>
    <p class="ml-2 mb-2">You need to register with a unique username and password (<a href="/register"
            class="text-blue-700">Sign up</a>)</p>

    <h3 class="font-semibold mt-4">How can I print my entries?</h3>
    <p class="ml-2 mb-2">You have to <a href="/request-data" class="text-blue-700">request here</a> and then we will
        send you all your data
        to your email. You can then
        unzip this file and print as many as you'd like. You may also print any diary entries directly from the web
        browser.</p>

    <h3 class="font-semibold mt-4">Who can see my entries?</h3>
    <p class="ml-2 mb-2">All entries are private by default which means they are not visible or can not be read by
        anyone without <a href="/login" class="text-blue-70">login</a> for the same diary.</p>

    <h3 class="font-semibold mt-4">How does privacy work?</h3>
    <p class="ml-2 mb-2">Privacy with us is very simple. Nobody can read your notes, except yourself. Nothing is "public" by default on E-diary. Also, your all entries are saved in the database in encrypted form. So no one can read except you..</p>

    <h3 class="font-semibold mt-4">How did the idea come about?</h3>
    <p class="ml-2 mb-2">We like to be melancholy, writing daily notes, and reading them over. We always assumed taking
        interesting notes required big bulky paper books. But as mobile phones got better and better, smaller and
        smaller, we decided to challenge that assumption. We created E-diary to solve three simple problems:
        <ol class="list-decimal list-inside">
            <li class="pl-2">Traditional paper diaries not in your pocket at all times. An online and mobile diary makes
                it almost
                always accessible.</li>
            <li class="pl-2">Making copies and backup your paper diary is a pain - write a note once, then access it
                (instantly)
                on multiple services.</li>
            <li class="pl-2">Most diary experiences are clumsy and take forever - we've optimized the experience to be
                fast and
                efficient.</li>
        </ol>
    </p>

    <h3 class="font-semibold mt-4">Why I am asked to give my email address?</h3>
    <p class="ml-2 mb-2">You can use this email later for resetting your password.</p>
</div>
@endsection
