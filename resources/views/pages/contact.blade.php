@extends('layouts.app')
@section('title', 'Contact Us – E-Diary')

@push('meta')
    <meta
        name="description"
        content="Get in touch with the E-diary support team for bug reports, feature requests, or general inquiries. Use our contact form to reach us quickly and easily."
    />
    <meta
        name="keywords"
        content="contact E-diary, support, customer service, feature requests, bug reports, contact form, inquiries"
    />
    <meta name="subject" content="Contact Us - E-diary" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/contact" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/contact" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Contact Us - E-diary" />
    <meta
        name="twitter:description"
        content="Reach out to the E-diary support team for assistance, bug reports, feature requests, or any other inquiries. We're here to help!"
    />
    <meta name="twitter:image" content="https://ediary.shakiltech.com/icons/android-icon-192x192.png" />
    <meta name="og:title" content="Contact Us - E-diary" />
    <meta name="og:url" content="https://ediary.shakiltech.com/contact" />
    <meta name="og:image" content="https://ediary.shakiltech.com/icons/android-icon-192x192.png" />
    <meta
        name="og:description"
        content="Need assistance or have a suggestion? Contact the E-diary support team via our easy-to-use contact form. We're happy to help!"
    />
@endpush

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Contact Us - E-diary",
            "url": "https://ediary.shakiltech.com/contact",
            "description": "Contact the E-diary support team for bug reports, feature requests, suggestions, or inquiries. Use the contact form for quick support.",
            "mainEntity": {
                "@type": "ContactPage",
                "contactOption": "support",
                "email": "mailto:support@ediary.shakiltech.com",
                "contactType": "Customer Support",
                "areaServed": "Worldwide",
                "availableLanguage": "English"
            },
            "potentialAction": {
                "@type": "CommunicateAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "https://ediary.shakiltech.com/contact",
                    "actionApplication": {
                        "@type": "WebApplication",
                        "name": "E-diary Contact Form",
                        "operatingSystem": "All",
                        "applicationCategory": "BusinessApplication",
                        "offers": {
                            "@type": "Offer",
                            "price": "0",
                            "priceCurrency": "USD"
                        },
                        "aggregateRating": {
                            "@type": "AggregateRating",
                            "ratingValue": "4.8",
                            "reviewCount": "125"
                        }
                    }
                },
                "name": "Submit Contact Form"
            }
        }
    </script>
@endpush
@section('content')
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 px-4 py-12">
        <div class="w-full max-w-6xl">
            <div class="flex flex-col overflow-hidden rounded-3xl shadow-2xl lg:flex-row">
                @include('auth.partials.left-branding')

                <!-- Right Side Contact Form -->
                <div class="w-full bg-white p-8 md:p-12 lg:w-1/2 dark:bg-gray-800">
                    <!-- Mobile Logo -->
                    <div class="mb-8 text-center lg:hidden">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100 dark:bg-blue-900">
                            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>

                    <!-- Form Header -->
                    <div class="mb-8 text-center">
                        <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Contact Us</h1>
                        <p class="text-balance text-gray-600 dark:text-gray-400">
                            Reach out to our support team for assistance, suggestions, or feedback.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('contact.send') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-form.label for="name">Name</x-form.label>
                            <x-form.input
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                placeholder="John Doe"
                                required
                                autofocus
                            />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.label for="email">Email Address</x-form.label>
                            <x-form.input
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="john@example.com"
                                required
                            />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.label for="message">Message</x-form.label>
                            <textarea
                                name="message"
                                id="message"
                                rows="6"
                                required
                                placeholder="Enter your message here..."
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2 text-gray-900 placeholder-gray-400 transition duration-150 ease-in-out focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-button.primary class="h-10 w-full">Send Message</x-button.primary>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
