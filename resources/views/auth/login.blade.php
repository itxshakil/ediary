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
        "@@context": "https://schema.org",
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
    <div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-6xl">
            <div class="flex flex-col lg:flex-row shadow-2xl rounded-3xl overflow-hidden">
                <!-- Left Side - Image/Branding -->
                @include('auth.partials.left-branding')

                <!-- Right Side - Login Form -->
                <div class="w-full lg:w-1/2 bg-white dark:bg-gray-800 p-8 md:p-12">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden mb-8 text-center">
                        <div class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Form Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            Welcome Back!
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            Continue your journaling journey
                        </p>
                    </div>

                    <!-- Login Form Component -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Username
                            </label>
                            <input
                                id="username"
                                type="text"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                autofocus
                                class="mt-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200
                   focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >
                            @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                class="mt-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200
                   focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >
                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                >
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                Remember Me
            </span>
                            </label>

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                                >
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit Button --}}
                        <div>
                            <button
                                type="submit"
                                class="w-full py-3 px-4 rounded-xl font-semibold text-white bg-blue-600
                   hover:bg-blue-700 transition-all duration-200 shadow-md"
                            >
                                Log In
                            </button>
                        </div>
                    </form>


                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                            New to Ediary?
                        </span>
                        </div>
                    </div>

                    <!-- Additional Links -->
                    <div class="space-y-4">
                        <a
                            href="{{ route('register') }}"
                            class="flex items-center justify-center w-full py-3 px-4 border-2 border-blue-600 dark:border-blue-500 text-blue-600 dark:text-blue-400 rounded-xl font-semibold hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Create a Free Account
                        </a>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors inline-flex items-center gap-1"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Need help accessing your account?
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Trust Badge for Mobile -->
                    <div class="lg:hidden mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-center">
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">4.8/5</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Rated by 1,524+ users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
