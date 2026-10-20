@extends('layouts.app')
@section('title', 'Private Online Diary That Works Offline')
@section('description', 'Ediary is a free, private online diary that works offline. Unlimited entries, encrypted at rest, private by default, and just an email to sign up.')
@push('head')
    <script type="application/ld+json">
        {!!
            json_encode([
                '@@context' => 'https://schema.org',
                '@graph' => [
                    [
                        // WebSite name/alternateName feed the site name Google shows above results.
                        '@type' => 'WebSite',
                        '@id' => url('/') . '#website',
                        'name' => 'Ediary',
                        'alternateName' => ['E-diary', 'Ediary App'],
                        'url' => url('/'),
                    ],
                    [
                        '@type' => 'WebApplication',
                        'name' => 'Ediary',
                        'url' => url('/'),
                        'description' => 'A free, private online diary that works offline. Unlimited entries, encrypted at rest and private by default.',
                        'applicationCategory' => 'LifestyleApplication',
                        'operatingSystem' => 'Any',
                        'browserRequirements' => 'Requires a modern web browser. Installable as an app.',
                        'isAccessibleForFree' => true,
                        'offers' => ['@type' => 'Offer', 'price' => 0, 'priceCurrency' => 'USD'],
                        'image' => url('/icons/android-icon-192x192.png'),
                        'screenshot' => [
                            url('/images/screenshots/ediary-welcome.png'),
                            url('/images/screenshots/ediary-features.png'),
                        ],
                        'author' => ['@type' => 'Person', 'name' => 'Shakil Alam', 'url' => 'https://github.com/itxshakil'],
                        'isPartOf' => ['@id' => url('/') . '#website'],
                    ],
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)
        !!}
    </script>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="from-primary-600 via-primary-700 relative overflow-hidden bg-gradient-to-br to-indigo-800 text-white">
        <!-- Subtle background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute inset-0"
                style="
                    background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0);
                    background-size: 40px 40px;
                "
            ></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pt-16 pb-20 sm:px-6 md:pt-28 md:pb-32 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <!-- Badge -->
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 backdrop-blur-sm">
                    <svg class="h-4 w-4 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">Free • Private • Works Offline</span>
                </div>

                <!-- Main Headline -->
                <h1 class="mb-4 text-4xl leading-tight font-bold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl">
                    A private online diary<br class="hidden sm:block" />
                    <span class="bg-gradient-to-r from-yellow-200 via-yellow-300 to-yellow-200 bg-clip-text text-transparent">that works offline</span>
                </h1>

                <!-- Subheadline -->
                <p class="text-primary-100 mx-auto mb-8 max-w-3xl text-xl leading-relaxed md:text-2xl">
                    Your life, your story. Unlimited entries, encrypted at rest, private by default, and nothing but an
                    email to sign up.
                </p>

                @guest
                    <div class="mx-auto mb-10 max-w-md md:max-w-3xl">
                        <div class="rounded-3xl border border-white/20 bg-white/95 p-6 shadow-2xl backdrop-blur-md md:p-10 dark:bg-gray-900/95">
                            <div class="mb-8 text-center">
                                <h2 class="text-2xl font-extrabold text-gray-900 md:text-3xl dark:text-white">
                                    Create Your Account
                                </h2>
                                <p class="mt-2 text-gray-600 dark:text-gray-400">
                                    Start your private journey in seconds
                                </p>
                            </div>

                            <form method="POST" action="{{ route('register') }}" class="space-y-5 text-left">
                                @csrf
                                <input type="hidden" name="timezone" data-timezone />

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label
                                            for="email"
                                            class="mb-1 block text-left text-sm font-semibold text-gray-700 dark:text-gray-200"
                                        >Email Address</label>
                                        <div class="group relative">
                                            <input
                                                id="email"
                                                type="email"
                                                name="email"
                                                required
                                                autocomplete="email"
                                                placeholder="you@example.com"
                                                value="{{ old('email') }}"
                                                class="field pr-4 pl-10"
                                            />
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-focus-within:text-primary-500 absolute top-3.5 left-3 h-5 w-5 text-gray-400 transition-colors">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                <path d="M3 7l9 6l9 -6" />
                                            </svg>
                                        </div>
                                        @error('email')
                                            <p class="mt-1 flex items-center text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            for="password"
                                            class="mb-1 block text-left text-sm font-semibold text-gray-700 dark:text-gray-200"
                                        >Password</label>
                                        <div class="group relative">
                                            <input
                                                id="password"
                                                type="password"
                                                name="password"
                                                required
                                                autocomplete="new-password"
                                                placeholder="At least 8 characters"
                                                minlength="8"
                                                class="field pr-12 pl-10"
                                            />
                                            <x-form.password-toggle for="password" />
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-focus-within:text-primary-500 absolute top-3.5 left-3 h-5 w-5 text-gray-400 transition-colors">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                            </svg>
                                        </div>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <x-button size="lg" type="submit" class="group w-full">
                                    <span class="flex items-center justify-center">
                                        Get Started Free
                                        <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </span>
                                </x-button>
                            </form>

                            <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-300">
                                Already have an account?
                                <a href="{{ route('login') }}" class="font-semibold underline">Sign in</a>
                            </p>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-20 md:py-32 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="mx-auto mb-16 max-w-3xl text-center">
                <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">
                    Everything you need to journal with confidence
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Built with your privacy and peace of mind as the top priority
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid gap-8 md:grid-cols-2 lg:gap-12">
                <!-- Feature 1 -->
                <div class="group reveal shadow-card hover:shadow-card-hover rounded-2xl bg-white p-8 transition-shadow duration-300 dark:bg-gray-800">
                    <div class="bg-primary-100 dark:bg-primary-900/30 mb-5 flex h-12 w-12 items-center justify-center rounded-xl transition-transform duration-300 group-hover:scale-110">
                        <svg class="text-primary-600 dark:text-primary-400 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">Private by Default</h3>
                    <p class="leading-relaxed text-gray-600 dark:text-gray-400">
                        Every entry is encrypted at rest with AES-256 and private unless you choose to share it. No ads,
                        no data selling, and the code is open source.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group reveal shadow-card hover:shadow-card-hover rounded-2xl bg-white p-8 transition-shadow duration-300 dark:bg-gray-800">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 transition-transform duration-300 group-hover:scale-110 dark:bg-purple-900/30">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">Zero Friction Writing</h3>
                    <p class="leading-relaxed text-gray-600 dark:text-gray-400">
                        Start writing in seconds. No complicated setup, no unnecessary fields. Just your email and
                        you're ready to capture life's moments.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group reveal shadow-card hover:shadow-card-hover rounded-2xl bg-white p-8 transition-shadow duration-300 dark:bg-gray-800">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 transition-transform duration-300 group-hover:scale-110 dark:bg-green-900/30">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">Write Anywhere, Anytime</h3>
                    <p class="leading-relaxed text-gray-600 dark:text-gray-400">
                        Inspiration doesn't wait for WiFi. Write offline and sync automatically when you're back online.
                        Your journal follows you everywhere.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group reveal shadow-card hover:shadow-card-hover rounded-2xl bg-white p-8 transition-shadow duration-300 dark:bg-gray-800">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 transition-transform duration-300 group-hover:scale-110 dark:bg-orange-900/30">
                        <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">App-Like Experience</h3>
                    <p class="leading-relaxed text-gray-600 dark:text-gray-400">
                        Add to your home screen for instant access. Lightning-fast, beautifully simple, and feels like a
                        native app—because it practically is.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Proof / Benefits Section -->
    <div class="bg-white py-20 md:py-32 dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-16 max-w-3xl text-center">
                <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">
                    Why people love journaling with Ediary
                </h2>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <div class="text-center">
                    <div class="text-primary-600 dark:text-primary-400 mb-2 text-4xl font-bold md:text-5xl">100%</div>
                    <div class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Private</div>
                    <p class="text-gray-600 dark:text-gray-400">
                        Entries are encrypted at rest and private unless you share them
                    </p>
                </div>
                <div class="text-center">
                    <div class="text-primary-600 dark:text-primary-400 mb-2 text-4xl font-bold md:text-5xl">0</div>
                    <div class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Personal Data</div>
                    <p class="text-gray-600 dark:text-gray-400">
                        No name, birthday, or ad trackers. Just your email for login
                    </p>
                </div>
                <div class="text-center">
                    <div class="text-primary-600 dark:text-primary-400 mb-2 text-4xl font-bold md:text-5xl">∞</div>
                    <div class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Entries</div>
                    <p class="text-gray-600 dark:text-gray-400">Write unlimited entries. No storage limits, ever</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Section -->
    <div class="bg-primary-600 reveal py-12">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-4 text-center sm:px-6 md:flex-row md:text-left lg:px-8">
            <div>
                <h2 class="mb-2 text-2xl font-bold text-white">Studying or doing research?</h2>
                <p class="text-primary-100">
                    Keep study logs and research reflections in a private journal that works offline.
                </p>
            </div>
            <a
                href="{{ url('/for-students') }}"
                class="text-primary-700 hover:bg-primary-50 shrink-0 rounded-xl bg-white px-6 py-3 text-sm font-bold shadow-md transition"
            >
                See how students use Ediary
            </a>
        </div>
    </div>

    <!-- Blog Section -->
    <div class="border-t border-gray-100 bg-gray-50 py-20 md:py-32 dark:border-gray-800 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 flex items-center justify-between">
                <div>
                    <h2 class="mb-2 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">From the blog</h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Guides to keeping a diary, journaling prompts, and journals for study and research.
                    </p>
                </div>
                <a
                    href="/blog"
                    class="text-primary-600 dark:text-primary-400 hidden items-center gap-2 font-bold hover:underline md:flex"
                >
                    View All Articles
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach (collect(config('blog.posts'))->filter(fn (array $post): bool => $post['listed'] ?? true)->take(3) as $slug => $post)
                    @include('blogs._card', ['slug' => $slug, 'post' => $post, 'heading' => 'h3'])
                @endforeach
            </div>
            <div class="mt-16 text-center md:hidden">
                <a
                    href="/blog"
                    class="text-primary-600 dark:text-primary-400 inline-flex items-center gap-2 font-bold hover:underline"
                >
                    View All Articles
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <div class="from-primary-600 via-primary-700 bg-gradient-to-br to-indigo-800 py-20 text-white md:py-32">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="mb-6 text-3xl font-bold md:text-5xl">Start your journey today</h2>
            <p class="text-primary-100 mx-auto mb-10 max-w-2xl text-xl">
                Write your first entry in under a minute. Your future self will thank you.
            </p>
            @guest
                <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <a
                        href="{{ route('register') }}"
                        class="text-primary-700 hover:bg-primary-50 inline-flex items-center justify-center rounded-full bg-white px-8 py-3 text-sm font-semibold shadow-sm transition"
                    >
                        Create your account
                    </a>
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center rounded-full border border-white/40 px-8 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                    >
                        Sign in
                    </a>
                </div>
            @endguest

            <p class="text-primary-200 mt-8 text-sm">Free forever. No credit card. Just an email.</p>
        </div>
    </div>

@endsection
