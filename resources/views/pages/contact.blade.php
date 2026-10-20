@extends('layouts.app')
@section('title', 'Contact Ediary')

@section('description', 'Questions, bug reports or feature ideas? Send a message about Ediary and we\'ll get back to you as soon as we can.')

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Contact Us - Ediary",
            "url": "https://ediary.shakiltech.com/contact",
            "description": "Contact the Ediary support team for bug reports, feature requests, suggestions, or inquiries. Use the contact form for quick support.",
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
                        "name": "Ediary Contact Form",
                        "operatingSystem": "All",
                        "applicationCategory": "BusinessApplication",
                        "offers": {
                            "@type": "Offer",
                            "price": "0",
                            "priceCurrency": "USD"
                        }
                    }
                },
                "name": "Submit Contact Form"
            }
        }
    </script>
@endpush
@section('content')
    <div class="from-primary-600 via-primary-700 flex min-h-screen items-center justify-center bg-gradient-to-br to-indigo-800 px-4 py-12">
        <div class="w-full max-w-6xl">
            <div class="flex flex-col overflow-hidden rounded-3xl shadow-2xl lg:flex-row">
                @include('auth.partials.left-branding')

                <!-- Right Side Contact Form -->
                <div class="w-full bg-white p-8 md:p-12 lg:w-1/2 dark:bg-gray-800">
                    <!-- Mobile Logo -->
                    <div class="mb-8 text-center lg:hidden">
                        <div class="bg-primary-100 dark:bg-primary-900 mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl">
                            <svg class="text-primary-600 dark:text-primary-400 h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                autocomplete="name"
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
                                type="email"
                                autocomplete="email"
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
                                class="field"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-button type="submit" class="w-full">Send Message</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
