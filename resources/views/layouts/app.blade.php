<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="google-site-verification" content="oRXIYL6yenkxhE2G4UhEjBQarn6Sb3Z3jRtBdBCoAWA" />

    <meta name="color-scheme" content="dark light">
    <meta name="owner" content="Shakil Alam" />
    <meta name="author" content="Shakil Alam , itxshakil@gmail.com" />

    <meta name="og:site_name" content="Ediary App" />
    <meta property="og:type" content="Website" />
    <meta property="og:logo" content="{{ url('/icons/android-icon-192x192.png') }}" />

    <meta name="og:email" content="appediary@gmail.com" />
    <meta name="og:country-name" content="India" />

    <!-- PWA Meta tag -->

    <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="msapplication-TileColor" content="#2d3748">
    <meta name="msapplication-TileImage" content="/icons/ms-icon-144x144.png">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#2d3748" />
    <meta name="apple-mobile-web-app-title" content="Shakil Alam | Portfolio" />
    <meta name="msapplication-TitleImage" content="/icons/old/icons-192.png" />
    <meta name="msapplication-TitleColor" content="#2d3748" />
    <meta name="theme-color" content="#2d3748">

    @stack('meta')

    <title>@yield('title',config('app.name')) | Ediary</title>

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5KBQKGS');
    </script>
    <!-- End Google Tag Manager -->
    @stack('head')

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "MobileApplication",
            "name": "E-diary",
            "url": "https://ediary.shakiltech.com",
            "description": "E-diary is the easiest and safest way to document your thoughts, memories, and experiences. With complete privacy and offline accessibility, it's the most convenient way to track your life journey.",
            "operatingSystem": "iOS, Android, Web",
            "applicationCategory": "Productivity",
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.8",
                "reviewCount": "138",
                "bestRating": "5",
                "worstRating": "1"
            },
            "author": {
                "@type": "Organization",
                "name": "Shakil Alam"
            },
            "image": "https://ediary.shakiltech.com/icons/android-icon-192x192.png",
            "screenshot": [
                "https://ediary.shakiltech.com/images/screenshots/ediary-features.png",
                "https://ediary.shakiltech.com/screenshots/ediary-welcome.png   "
            ],
            "isAccessibleForFree": true,
            "offers": {
                "@type": "Offer",
                "url": "https://ediary.shakiltech.com/login",
                "priceCurrency": "USD",
                "price": 0.00,
                "availability": "https://schema.org/InStock"
            },
            "releaseNotes": "E-diary now supports offline entry saving and automatic syncing once you're online again.",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "https://ediary.shakiltech.com/search?q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>

    @stack('scripts')
</head>

<body class="font-sans antialiased accent-blue-500 dark:bg-gray-900 dark:text-white">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5KBQKGS" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="app" class="min-h-screen flex flex-col justify-between overflow-x-hidden">
        @include('includes.navbar')

        <main>
            @yield('content')
            <flash message="{{session('flash')}}"></flash>
        </main>
        @include('includes.footer')
    </div>
    <script>
        if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                // console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
            console.log('ServiceWorker registration failed: ', err);
            });
        });
        }
    </script>
    @if(Auth::user())
    <script>
        window.User = {!! json_encode(Auth::user()) !!}
    </script>
    @endif
</body>
