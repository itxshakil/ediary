@extends('layouts.app')
@section('title', 'Verify Your Email Address')

@push('meta')
    <link rel="canonical" href="{{ url('email/verify') }}" />
    <meta
        name="description"
        content="Verify your email to activate your secure E-Diary account. Join 1,500+ users enjoying a private, encrypted, and distraction-free space to store their thoughts."
    />
    <meta name="keywords" content="email verification, secure diary, verify account, private notes app, E-Diary" />
    <meta name="subject" content="Verify your E-Diary account email" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="{{ url('email/verify') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Verify Your Email – Activate Your Secure E-Diary Account" />
    <meta
        name="twitter:description"
        content="Just one step left! Verify your email to activate your encrypted E-Diary account and join thousands of users worldwide."
    />
    <meta name="twitter:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:title" content="Verify Your Email – Activate Your Secure E-Diary Account" />
    <meta name="og:url" content="{{ url('email/verify') }}" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta
        name="og:description"
        content="Complete your signup. Verify your email to unlock your fully private and secure E-Diary account."
    />
@endpush

@push('head')
    <script type="application/ld+json">
                {
                    "@@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Email Verification – E-Diary",
            "url": "{{ url('email/verify') }}",
            "description": "Verify your email to activate your secure and encrypted E-Diary account. Rated 4.8/5 by 1,524 users.",
            "publisher": {
                "@type": "Organization",
                "name": "E-Diary",
                "url": "https://ediary.shakiltech.com",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://ediary.shakiltech.com/icons/android-icon-192x192.png"
                }
            },
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
                        "name": "Email Verification",
                        "item": "{{ url('email/verify') }}"
                    }
                ]
            }
        }
    </script>
@endpush

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-600/90 via-blue-700 to-indigo-800 px-4 py-12">
        <div class="w-full max-w-5xl">
            <div class="flex flex-col overflow-hidden rounded-3xl bg-white shadow-2xl lg:flex-row dark:bg-gray-800">
                @include('auth.partials.left-branding')

                <div class="w-full p-8 sm:p-12 lg:w-1/2">
                    <div class="mb-8 text-center">
                        <h1 class="mb-2 text-3xl font-semibold text-gray-900 dark:text-white">Verify your email</h1>
                        <p class="text-sm text-balance text-gray-600 dark:text-gray-400">
                            Verify your email to unlock your secure and private journaling space.
                        </p>
                    </div>

                    <!-- Success Message -->
                    @if (session('resent'))
                        <div class="mb-6 rounded-xl bg-green-50 px-4 py-3 text-center text-sm text-green-700 dark:bg-green-900/20 dark:text-green-300">
                            A new verification link has been sent to your email.
                        </div>
                    @endif

                    <!-- Info Card -->
                    <div class="space-y-4 rounded-2xl border border-gray-200/70 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-700/50">
                        <p class="text-sm leading-relaxed text-balance text-gray-700 dark:text-gray-300">
                            Before proceeding, please check your email inbox (and spam folder) for a verification link.
                        </p>

                        <p class="text-sm text-gray-700 dark:text-gray-300">Didn’t receive it?</p>

                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button
                                type="submit"
                                class="h-11 w-full rounded-xl bg-blue-600 font-medium text-white transition hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 focus:outline-none active:scale-[0.98]"
                            >
                                Resend verification email
                            </button>
                        </form>
                    </div>

                    <!-- Divider -->
                    <div class="relative my-10">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-white px-4 text-gray-400 dark:bg-gray-800"> Need help? </span>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="text-center">
                        <a
                            href="{{ url('/support') }}"
                            class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline dark:text-blue-400"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2
                                     2.21 0 4 1.343 4 3
                                     0 1.4-1.278 2.575-3.006 2.907
                                     -.542.104-.994.54-.994 1.093m0 3h.01
                                     M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            Contact support
                        </a>
                    </div>

                    <!-- Mobile Rating -->
                    <div class="mt-8 rounded-xl bg-blue-50 p-4 text-center lg:hidden dark:bg-blue-900/20">
                        <div class="mb-1 flex items-center justify-center gap-2">
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">4.8</span>
                            <span class="text-sm text-gray-500">/ 5</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Rated by 1,524+ users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
