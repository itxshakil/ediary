<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('includes.meta')

    <title>@yield('title',config('app.name'))</title>

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162113606-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-162113606-1');
    </script>

    @stack('scripts')
</head>

<body>
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
            navigator.serviceWorker.register('/sw.js', {scope: './'})
            .then(function(registration) {
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