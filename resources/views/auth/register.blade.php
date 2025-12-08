@extends('layouts.app')
@section('title','Create Your Ediary Account – Join Free Today!')
@push('meta')
    <link rel="canonical" href="{{ url('register') }}" />
    <meta name="description" content="Create your free E-Diary account today! Rated 4.8/5 by 1,524 users. Join the safest and most private online diary trusted by thousands worldwide." />
    <meta name="keywords" content="create diary account, free diary registration, secure diary signup, E-Diary register, start journaling, shakil alam" />
    <meta name="subject" content="Register for your secure E-Diary account | Rated 4.8/5 by users!" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/register" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/register" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Sign Up for E-Diary – Your Private Space for Thoughts | Rated 4.8/5!" />
    <meta name="twitter:description" content="Start your journaling journey with E-Diary — secure, private, and trusted by 1,524+ users worldwide. Create your account for free today!" />
    <meta name="twitter:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:title" content="Sign Up for E-Diary – The Most Secure Online Diary | Rated 4.8/5!" />
    <meta name="og:url" content="https://ediary.shakiltech.com/register" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:description" content="Join thousands of users who trust E-Diary for safe, private journaling. Create your free account today and start writing your story." />
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const usernameInput = document.getElementById("username");

            if (!usernameInput) return;

            let typingTimer;
            const debounceDelay = 400;

            let statusBox = document.getElementById("username-status");

            if (!statusBox) {
                statusBox = document.createElement("div");
                statusBox.id = "username-status";
                statusBox.className = "mt-1 text-sm";
                usernameInput.parentNode.appendChild(statusBox);
            }

            usernameInput.addEventListener("input", () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(checkUsername, debounceDelay);
            });

            function checkUsername() {
                const username = usernameInput.value.trim();

                if (username.length < 4) {
                    statusBox.textContent = "Minimum 4 characters required";
                    statusBox.className = "mt-1 text-sm text-red-600";
                    return;
                }

                statusBox.textContent = "Checking availability…";
                statusBox.className = "mt-1 text-sm text-gray-500";

                axios.post("/api/check-username", { username })
                    .then(res => {
                        if (res.data.success) {
                            statusBox.textContent = "✔ Username available";
                            statusBox.className = "mt-1 text-sm text-green-600";
                        } else {
                            statusBox.textContent = "✖ Username already taken";
                            statusBox.className = "mt-1 text-sm text-red-600";
                        }
                    })
                    .catch(() => {
                        statusBox.textContent = "Error checking username";
                        statusBox.className = "mt-1 text-sm text-red-600";
                    });
            }
        });
    </script>
@endpush

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
    "@type": "WebPage",
    "name": "E-Diary Registration",
    "url": "https://ediary.shakiltech.com/register",
    "description": "Start journaling securely with E-Diary. Rated 4.8/5 by 1,524+ users. Create your free account today!",
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
                "name": "Ava"
            },
            "reviewBody": "The perfect place to write my daily thoughts. Love how private and secure it is!"
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
                "name": "Noah"
            },
            "reviewBody": "Simple, elegant, and really secure. Great for daily journaling!"
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
                "name": "Register",
                "item": "https://ediary.shakiltech.com/register"
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

                {{-- Left Side Branding (unchanged) --}}
                @include('auth.partials.left-branding')

                {{-- Right Section – Registration --}}
                <div class="w-full lg:w-1/2 bg-white dark:bg-gray-800 p-8 md:p-12">

                    {{-- Mobile Logo --}}
                    <div class="lg:hidden mb-8 text-center">
                        <div class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Header --}}
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            Create Your Free Account
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            Start your private journaling journey today
                        </p>
                    </div>

                    {{-- Register Form --}}
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        {{-- Username --}}
                        <div>
                            <x-form.label for="username">Username</x-form.label>

                            <x-form.input
                                id="username"
                                name="username"
                                placeholder="johndoe"
                                required
                                autocomplete="off"
                            />

                            @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-form.label for="email">Email Address</x-form.label>

                            <x-form.input
                                id="email"
                                type="email"
                                name="email"
                                placeholder="you@example.com"
                                required
                                autocomplete="email"
                            />

                            @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-form.label for="password">Password</x-form.label>

                            <x-form.input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                minlength="8"
                                required
                                autocomplete="new-password"
                            />

                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <x-form.label for="password_confirmation">Confirm Password</x-form.label>

                            <x-form.input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="••••••••"
                                minlength="8"
                                required
                                autocomplete="new-password"
                            />
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full py-3.5 rounded-xl font-semibold text-white
               bg-gradient-to-r from-blue-600 to-blue-700
               hover:scale-[1.01] transition shadow-md">
                            Create Account
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                            Already have an account?
                        </span>
                        </div>
                    </div>

                    {{-- Link to Login --}}
                    <a href="{{ route('login') }}"
                       class="flex items-center justify-center w-full py-3 px-4 border-2 border-blue-600 dark:border-blue-500
                       text-blue-600 dark:text-blue-400 rounded-xl font-semibold hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all">
                        Log In Instead
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
