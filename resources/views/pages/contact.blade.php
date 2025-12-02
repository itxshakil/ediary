@extends('layouts.app')
@section('title','Contact Us through form')

@push('meta')
    <meta name="description" content="Get in touch with the E-diary support team for bug reports, feature requests, or general inquiries. Use our contact form to reach us quickly and easily." />
    <meta name="keywords" content="contact E-diary, support, customer service, feature requests, bug reports, contact form, inquiries" />
    <meta name="subject" content="Contact Us - E-diary" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
    <meta name="url" content="https://ediary.shakiltech.com/contact" />
    <meta name="identifier-URL" content="https://ediary.shakiltech.com/contact" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@itxshakil" />
    <meta name="twitter:title" content="Contact Us - E-diary" />
    <meta name="twitter:description" content="Reach out to the E-diary support team for assistance, bug reports, feature requests, or any other inquiries. We're here to help!" />
    <meta name="twitter:image" content="https://ediary.shakiltech.com/icons/android-icon-192x192.png" />
    <meta name="og:title" content="Contact Us - E-diary" />
    <meta name="og:url" content="https://ediary.shakiltech.com/contact" />
    <meta name="og:image" content="https://ediary.shakiltech.com/icons/android-icon-192x192.png" />
    <meta name="og:description" content="Need assistance or have a suggestion? Contact the E-diary support team via our easy-to-use contact form. We're happy to help!" />
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
<div class="container mx-auto flex justify-center px-3 md:px-6 dark:bg-gray-900 dark:text-white">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6">
        <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg" style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800'); background-position: center center;">
        </div>
        <div class="w-full lg:w-1/2 bg-gray-200 dark:bg-gray-800 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h1 class="pt-4 text-2xl text-center pb-6 md:pb-4 dark:text-white">Contact us!</h1>
            <form class="px-3 md:px-8 pb-2 mb-4 bg-white dark:bg-gray-900 rounded pt-2" method="POST" action="{{ route('contact.send') }}">
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="name">
                        Name
                    </label>
                    <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 dark:text-gray-200 border rounded shadow appearance-none focus:outline-none @error('name') border-red-500 @enderror" id="name" type="text" placeholder="John Doe" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus />
                    @error('name')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="email">
                        Email address
                    </label>
                    <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 dark:text-gray-200 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror" id="email" type="email" placeholder="john@example.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                    @error('email')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="message">
                        Message
                    </label>
                    <resizable-textarea>
                        <textarea class="w-full px-3 text-sm leading-tight text-gray-700 dark:text-gray-200 border rounded shadow appearance-none focus:outline-none @error('message') border-red-500 @enderror" name="message" id="message" cols="30" rows="10" placeholder="Bug report/ Feature request/Suggestion and more..." required autofocus value="{{old('message')}}"></textarea>
                    </resizable-textarea>
                    @error('message')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 text-center">
                    <button class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none uppercase shadow hover:shadow-md font-bold text-xs" type="submit">
                        Send
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
