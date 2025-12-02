@extends('layouts.app')
@section('title','Register new account')

@push('meta')
    <link rel="canonical" href="{{ url('register') }}" />
    <meta name="description" content="Create your free E-Diary account today! Secure, private, and easy to use. Register now and start your private journaling journey." />
    <meta name="keywords" content="ediary register, secure diary registration, privacy-friendly diary app, encrypted diary, shakil alam, register free diary account" />
    <meta name="subject" content="Register a free, secure account with E-Diary | Privacy-Friendly and Encrypted" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/register" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/register" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Register Now for E-Diary – Secure and Private Journaling!" />
    <meta name="twitter:description" content="Join E-Diary, the most secure and private journaling platform. Create a free account now and start writing your thoughts today!" />
    <meta name="twitter:image" content="/icons/register-page-preview.png" />
    <meta name="og:title" content="Register for E-Diary – Secure, Private, and Free!" />
    <meta name="og:url" content="https://ediary.shakiltech.com/register" />
    <meta name="og:image" content="/icons/register-page-preview.png" />
    <meta name="og:description" content="E-Diary is privacy-friendly and secure. Register your account today to start journaling with full encryption and offline support." />
@endpush

@push('head')
    <script type="application/ld+json">
        {
        "@@context": "https://schema.org",
        "@type": "WebPage",
        "name": "E-Diary Registration",
        "url": "https://ediary.shakiltech.com/register",
        "description": "Join E-Diary, the most secure and private journaling platform. Create a free account now and start writing your thoughts today!",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "1830",
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
                "name": "Emily R."
            },
            "reviewBody": "E-Diary registration was so easy, and I love the app's privacy features!"
            },
            {
            "@type": "Review",
            "reviewRating": {
                "@type": "Rating",
                "ratingValue": "5",
                "bestRating": "5"
            },
            "author": {
                "@type": "Person",
                "name": "James P."
            },
            "reviewBody": "Finally, a secure diary app! Registration was quick and simple."
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
<div class="container mx-auto flex justify-center px-3 md:px-6">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6">
        <div class="w-full h-auto hidden lg:block lg:w-1/2 bg-cover rounded-l-lg bg-blue-700">
            <div class="flex flex-col text-gray-200 justify-center items-center">
                <div class="feature p-4 mb-1">
                    <h3 class="mb-2 text-xl flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="mr-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>Privacy
                    </h3>
                    <p class="w-96">We respect your privacy. We don't ask for any personal details such as Your name,
                        Date of birth, etc. We ask for your Email-address for verification purposes only.</p>
                </div>
                <div class="feature p-4 mb-1">
                    <h3 class="mb-2 text-xl flex flex-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>Secure
                    </h3>
                    <p class="w-96">Your all entries in the diary are private by default. We save your entry in
                        encrypted
                        form in the Database. So no one
                        can read it except you.</p>
                </div>
                <div class="feature p-4 mb-1">
                    <h3 class="mb-2 text-xl flex flex-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-wifi-off">
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                            <path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55"></path>
                            <path d="M5 12.55a10.94 10.94 0 0 1 5.17-2.39"></path>
                            <path d="M10.71 5.05A16 16 0 0 1 22.58 9"></path>
                            <path d="M1.42 9a15.91 15.91 0 0 1 4.7-2.88"></path>
                            <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                            <line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>Availability
                    </h3>
                    <p class="w-96">When You aren't connected to the Internet(Offline). Then we save your entry in your
                        device and sync back to the database when the connection back to the Internet.</p>
                </div>
                <div class="feature p-4 mb-1">
                    <h3 class="mb-2 text-xl flex flex-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>Installable
                    </h3>
                    <p class="w-96">For easy access, you can add Ediary to your Home Screen. So you can use it as native
                        apps.</p>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 bg-gray-200 dark:bg-gray-800 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h1 class="pt-4 text-2xl text-center pb-2 md:pb-4 text-gray-900 dark:text-white">Register new account!</h1>
            <form class="px-4 md:px-8  pt-6 pb-2 mb-4 bg-white dark:text-white dark:bg-gray-900 rounded" method="POST" action="/register">
                <section class="mb-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="username">
                        Username
                    </label>
                    <username-input @error('email') :iserror="true" @enderror value="{{old('username')}}">
                    </username-input>
                    @error('username')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </section>
                <section class="mb-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="email">
                        Email-Address
                    </label>
                    <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 dark:text-gray-200 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror" id="email" type="email" placeholder="john@example.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                    @error('email')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </section>
                <section class="mb-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="password">
                        Password
                    </label>
                    <input class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('password') border-red-500 @enderror" id="password" type="password" name="password" placeholder="******************" autocomplete="new-password" />
                    @error('password')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </section>
                <section class="mb-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="password_confirmation">
                        Confirm Password
                    </label>
                    <input class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('password_confirmation') border-red-500 @enderror" id="password_confirmation" type="password" name="password_confirmation" placeholder="******************" />
                    @error('password_confirmation')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </section>
                <section class="mb-4 text-center">
                    <button class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs" type="submit">
                        Register Now
                    </button>
                </section>
                @csrf
            </form>
            <hr class="mb-6 mx-8 border-t" />
            <div class="text-center">
                <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="{{ route('login')}}">
                    Already have an account Login!
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
