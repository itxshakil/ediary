@extends('layouts.app')
@section('title','Verify Your Email Address')

@push('meta')
    <link rel="canonical" href="{{ url('email/verify') }}" />
    <meta name="description" content="Verify your email to activate your secure E-Diary account. Join 1,500+ users enjoying a private, encrypted, and distraction-free space to store their thoughts." />
    <meta name="keywords" content="email verification, secure diary, verify account, private notes app, E-Diary" />
    <meta name="subject" content="Verify your E-Diary account email" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="{{ url('email/verify') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Verify Your Email – Activate Your Secure E-Diary Account" />
    <meta name="twitter:description" content="Just one step left! Verify your email to activate your encrypted E-Diary account and join thousands of users worldwide." />
    <meta name="twitter:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:title" content="Verify Your Email – Activate Your Secure E-Diary Account" />
    <meta name="og:url" content="{{ url('email/verify') }}" />
    <meta name="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
    <meta name="og:description" content="Complete your signup. Verify your email to unlock your fully private and secure E-Diary account." />
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
    <div class="min-h-screen bg-gradient-to-br from-blue-600/90 via-blue-700 to-indigo-800
            flex items-center justify-center px-4 py-12">

        <div class="w-full max-w-5xl">
            <div class="flex flex-col lg:flex-row
                    rounded-3xl overflow-hidden
                    bg-white dark:bg-gray-800
                    shadow-2xl">

                @include('auth.partials.left-branding')

                <div class="w-full lg:w-1/2 p-8 sm:p-12">

                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-2">
                            Verify your email
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 text-sm text-balance">
                            Verify your email to unlock your secure and private journaling space.
                        </p>
                    </div>

                    <!-- Success Message -->
                    @if (session('resent'))
                        <div class="mb-6 rounded-xl px-4 py-3
                                bg-green-50 dark:bg-green-900/20
                                text-green-700 dark:text-green-300
                                text-sm text-center">
                            A new verification link has been sent to your email.
                        </div>
                    @endif

                    <!-- Info Card -->
                    <div class="rounded-2xl border border-gray-200/70 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-700/50
                            p-6 space-y-4">

                        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed text-balance">
                            Before proceeding, please check your email inbox (and spam folder) for a verification link.
                        </p>

                        <p class="text-gray-700 dark:text-gray-300 text-sm">
                            Didn’t receive it?
                        </p>

                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full h-11 rounded-xl
                                       bg-blue-600 hover:bg-blue-700
                                       text-white font-medium
                                       transition active:scale-[0.98]
                                       focus:outline-none focus:ring-4 focus:ring-blue-500/20">
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
                        <span class="px-4 bg-white dark:bg-gray-800 text-gray-400">
                            Need help?
                        </span>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="text-center">
                        <a href="{{ url('/support') }}"
                           class="inline-flex items-center gap-1
                              text-sm text-blue-600 dark:text-blue-400
                              hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8.228 9c.549-1.165 2.03-2 3.772-2
                                     2.21 0 4 1.343 4 3
                                     0 1.4-1.278 2.575-3.006 2.907
                                     -.542.104-.994.54-.994 1.093m0 3h.01
                                     M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Contact support
                        </a>
                    </div>

                    <!-- Mobile Rating -->
                    <div class="lg:hidden mt-8 rounded-xl bg-blue-50 dark:bg-blue-900/20 p-4 text-center">
                        <div class="flex items-center justify-center gap-2 mb-1">
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">4.8</span>
                            <span class="text-sm text-gray-500">/ 5</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            Rated by 1,524+ users
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

