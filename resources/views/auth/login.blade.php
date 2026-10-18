@extends('layouts.app')
@section('title', 'Login to your Ediary account')
@push('meta')
    <link rel="canonical" href="{{ url('login') }}" />
    <meta
        name="description"
        content="Log in to E-Diary and keep writing your private thoughts. Private by default and encrypted at rest."
    />
    <meta
        name="keywords"
        content="secure diary login, E-Diary secure login, privacy-friendly login, diary app login, shakil alam"
    />
    <meta name="subject" content="Log in to access your private diary" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/login" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/login" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Log in to E-Diary – Your Private Space for Thoughts" />
    <meta
        name="twitter:description"
        content="Log in to E-Diary, a private, encrypted space to track your thoughts and goals."
    />
    <meta name="twitter:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:title" content="Log in to E-Diary – Your Private Space for Thoughts" />
    <meta name="og:url" content="https://ediary.shakiltech.com/login" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta
        name="og:description"
        content="E-Diary is privacy-friendly and encrypted at rest. Log in now to continue your journey!"
    />
@endpush

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "WebPage",
            "name": "E-Diary Login",
            "url": "https://ediary.shakiltech.com/login",
            "description": "Log in to E-Diary, a private, encrypted space to track your thoughts and goals.",
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
                "sameAs": ["https://twitter.com/itxshakil", "https://www.linkedin.com/in/shakil-alam"]
            }
        }
    </script>
@endpush

@section('content')
    <div class="from-primary-600 via-primary-700 flex min-h-screen items-center justify-center bg-gradient-to-br to-indigo-800 px-4 py-12">
        <div class="w-full max-w-6xl">
            <div class="flex flex-col overflow-hidden rounded-3xl shadow-2xl lg:flex-row">
                <!-- Left Side - Image/Branding -->
                @include('auth.partials.left-branding')

                <!-- Right Side - Login Form -->
                <div class="w-full bg-white p-8 md:p-12 lg:w-1/2 dark:bg-gray-800">
                    <!-- Mobile Logo -->
                    <div class="mb-8 text-center lg:hidden">
                        <div class="bg-primary-100 dark:bg-primary-900 mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl">
                            <svg class="text-primary-600 dark:text-primary-400 h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>

                    <!-- Form Header -->
                    <div class="mb-8">
                        <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Welcome Back!</h1>
                        <p class="text-gray-600 dark:text-gray-400">Continue your journaling journey</p>
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
                                class="focus:ring-primary-500 mt-2 w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 focus:ring-2 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                            />
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
                                class="focus:ring-primary-500 mt-2 w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 focus:ring-2 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                            />
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
                                    class="text-primary-600 focus:ring-primary-500 h-4 w-4 rounded border-gray-300"
                                />
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300"> Remember Me </span>
                            </label>

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-primary-600 dark:text-primary-400 text-sm hover:underline"
                                >
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit Button --}}
                        <div>
                            <button
                                type="submit"
                                class="bg-primary-600 hover:bg-primary-700 w-full rounded-xl px-4 py-3 font-semibold text-white shadow-md transition-all duration-200"
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
                            <span class="bg-white px-4 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                New to Ediary?
                            </span>
                        </div>
                    </div>

                    <!-- Additional Links -->
                    <div class="space-y-4">
                        <a
                            href="{{ route('register') }}"
                            class="border-primary-600 text-primary-600 hover:bg-primary-50 dark:border-primary-500 dark:text-primary-400 dark:hover:bg-primary-900/20 flex w-full items-center justify-center rounded-xl border-2 px-4 py-3 font-semibold transition-all duration-200"
                        >
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Create a Free Account
                        </a>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a
                                    href="{{ route('password.request') }}"
                                    class="hover:text-primary-600 dark:hover:text-primary-400 inline-flex items-center gap-1 text-sm text-gray-600 transition-colors dark:text-gray-400"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Need help accessing your account?
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Trust Badge for Mobile -->
                    <div class="bg-primary-50 dark:bg-primary-900/20 mt-8 rounded-xl p-4 text-center lg:hidden">
                        <div class="mb-2 flex items-center justify-center gap-2">
                            <svg class="text-primary-600 dark:text-primary-400 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Private by default</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Encrypted at rest. Works offline.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
