<link rel="canonical" href="{{ url('/') }}" />
<meta
    name="description"
    content="Ediary is a free, private online diary that works offline. Unlimited entries, encrypted at rest, private by default, and just an email to sign up."
/>
<meta
    name="keywords"
    content="ediary,ediary app, private diary, secure diary,privacy friendly , diary App , save diary , free ediary offline , pwa, shakil alam"
/>
<meta name="subject" content="Ediary - Securely Document Your Life, Free & Effortless" />
<meta name="language" content="en" />
<meta name="rating" content="General" />
<meta name="url" content="https://ediary.shakiltech.com/" />
<meta name="identifier-URL" content="https://ediary.shakiltech.com/" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@itxshakil" />
<meta name="twitter:title" content="Ediary - Securely Document Your Life, Free & Effortless" />
<meta name="twitter:creator" content="@itxshakil" />
<meta property="og:title" content="Ediary - Securely Document Your Life, Free & Effortless" />
<meta property="og:url" content="https://ediary.shakiltech.com/" />
<meta property="og:image" content="{{ url('/icons/android-icon-192x192.png') }}" />
<meta
    property="og:description"
    content="Ediary is a free, private online diary that works offline. Unlimited entries, encrypted at rest, private by default, and just an email to sign up."
/>
<script type="application/ld+json">
    {!!
        json_encode([
            '@context' => 'https://schema.org',
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
