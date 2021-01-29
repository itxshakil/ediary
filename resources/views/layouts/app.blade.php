<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('includes.meta')

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

    @stack('scripts')
</head>

<body>
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