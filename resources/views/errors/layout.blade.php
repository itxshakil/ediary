<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="color-scheme" content="dark light" />
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png" />
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}" />
    <title>
        @yield('title')
        | Ediary
    </title>
    @yield('head')
</head>
<body class="error-page" data-tone="@yield('tone', 'info')">
    <div class="error-blob" aria-hidden="true"></div>

    <main class="error-shell">
        <div class="error-card">
            <p class="error-code">@yield('code')</p>
            <span class="error-eyebrow">@yield('eyebrow')</span>
            <h1 class="error-title">@yield('heading')</h1>
            <p class="error-description">@yield('description')</p>

            @yield('body')

            <div class="error-actions">
                @yield('actions')
            </div>

            @hasSection('details')
                <details class="error-details">
                    @yield('details')
                </details>
            @endif
        </div>
    </main>

    @hasSection('extra')
        <section class="error-extra">
            @yield('extra')
        </section>
    @endif
</body>
</html>
