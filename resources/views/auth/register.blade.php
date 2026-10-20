@extends('layouts.app')
@section('title', 'Create a Free Private Diary')
@section('description', 'Create your free Ediary account with just an email. Private by default, encrypted at rest, unlimited entries, and works offline.')

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Ediary Registration",
            "url": "https://ediary.shakiltech.com/register",
            "description": "Start journaling privately with Ediary. Create your free account today!",
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
                "name": "Ediary",
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
                {{-- Left Side Branding (unchanged) --}}
                @include('auth.partials.left-branding')

                {{-- Right Section – Registration --}}
                <div class="w-full bg-white p-8 md:p-12 lg:w-1/2 dark:bg-gray-800">
                    {{-- Mobile Logo --}}
                    <div class="mb-8 text-center lg:hidden">
                        <div class="bg-primary-100 dark:bg-primary-900 mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl">
                            <svg class="text-primary-600 dark:text-primary-400 h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>

                    {{-- Header --}}
                    <div class="mb-8">
                        <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Create Your Free Account</h1>
                        <p class="text-gray-600 dark:text-gray-400">Start your private journaling journey today</p>
                    </div>

                    {{-- Register Form --}}
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

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

                            <div class="relative">
                                <x-form.input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="At least 8 characters"
                                    minlength="8"
                                    required
                                    autocomplete="new-password"
                                    class="pr-12"
                                />
                                <x-form.password-toggle for="password" />
                            </div>

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <x-button size="lg" type="submit" class="w-full"> Create Account </x-button>
                    </form>

                    {{-- Divider --}}
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-white px-4 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                Already have an account?
                            </span>
                        </div>
                    </div>

                    {{-- Link to Login --}}
                    <a
                        href="{{ route('login') }}"
                        class="border-primary-600 text-primary-600 hover:bg-primary-50 dark:border-primary-500 dark:text-primary-400 dark:hover:bg-primary-900/20 flex w-full items-center justify-center rounded-xl border-2 px-4 py-3 font-semibold transition-all"
                    >
                        Log In Instead
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
