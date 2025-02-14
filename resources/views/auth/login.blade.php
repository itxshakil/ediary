@extends('layouts.app')
@section('title','Login to your Ediary account')
@push('meta')
    <link rel="canonical" href="{{ url('login') }}" />
    <meta name="description" content="Log in to E-Diary now! Rated 4.8/5 by 1,524 users. Join for free and start writing your private thoughts today." />
    <meta name="keywords" content="secure diary login, E-Diary secure login, privacy-friendly login, highly-rated app, diary app login, shakil alam" />
    <meta name="subject" content="Log in to access your private diary | Rated 4.8/5 by users!" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/login" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/login" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Log in to E-Diary – Your Secure Space for Thoughts | Rated 4.8/5!" />
    <meta name="twitter:description" content="Join thousands of satisfied users! Log in to E-Diary – the most secure and private way to track your thoughts and goals. Rated 4.8/5 by 1,524 happy users!" />
    <meta name="twitter:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:title" content="Log in to E-Diary – Your Secure Space for Thoughts | Rated 4.8/5!" />
    <meta name="og:url" content="https://ediary.shakiltech.com/login" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:description" content="E-Diary is privacy-friendly and secure. Rated 4.8/5 by 1,524 users. Log in now to start your journey!" />
@endpush

@push('head')
<script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "E-Diary Login",
    "url": "https://ediary.shakiltech.com/login",
    "description": "Join thousands of satisfied users! Log in to E-Diary – the most secure and private way to track your thoughts and goals. Rated 4.8/5 by 1,524 happy users!",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "1524",
        "bestRating": "5",
        "worstRating": "1"
    },
    "review": [
        {
        "@type": "Review",
        "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
        },
        "author": {
            "@type": "Person",
            "name": "Sophia"
        },
        "reviewBody": "E-Diary has been life-changing! I love how secure and easy it is to use."
        },
        {
        "@type": "Review",
        "reviewRating": {
            "@type": "Rating",
            "ratingValue": "4",
            "bestRating": "5"
        },
        "author": {
            "@type": "Person",
            "name": "Liam"
        },
        "reviewBody": "Great app for keeping track of my thoughts. Highly recommend!"
        }
    ],
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://ediary.shakiltech.com/"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "Login",
            "item": "https://ediary.shakiltech.com/login"
        }
        ]
    },
    "publisher": {
        "@type": "Organization",
        "name": "E-Diary",
        "url": "https://ediary.shakiltech.com",
        "logo": {
        "@type": "ImageObject",
        "url": "https://ediary.shakiltech.com/icons/android-icon-192x192.png"
        },
        "sameAs": [
        "https://twitter.com/itxshakil",
        "https://www.linkedin.com/in/shakil-alam"
        ]
    }
    }
</script>
@endpush
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6 shadow">
        <div class="w-full h-auto bg-gray-400 dark:bg-gray-600 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg" style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800'); background-position: center center;; background-position: center;">
        </div>
        <div class="w-full lg:w-1/2 bg-gray-200 dark:bg-gray-800 dark:text-white p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h1 class="pt-4 text-2xl text-center pb-2 md:pb-4 text-gray-900 dark:text-white dark:text-white">Welcome Back!</h1>
            <login-form class="px-4 md:px-8 pt-6 pb-2 mb-4 bg-white dark:text-white rounded"></login-form>
            <hr class="mb-6 mx-8 border-t" />
            <div class="text-center">
                <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="{{ route('register')}}">
                    Create an Account!
                </a>
            </div>
            @if (Route::has('password.request'))
            <div class="text-center">
                <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
