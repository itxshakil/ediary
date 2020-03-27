<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title',config('app.name'))</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('scripts')
</head>

<body>
    <div id="app" class="min-h-screen flex flex-col justify-between">
        @include('includes.navbar')
        
        <main>
            @yield('content')
            <flash message="{{session('flash')}}"></flash>
        </main>
        @include('includes.footer')
    </div>
</body>

