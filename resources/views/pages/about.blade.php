@extends('layouts.app')
@section('title', 'About Ediary: A Free, Private Online Diary')
@section('description', 'Why Ediary exists: a free, private online diary that works offline, asks for nothing but an email, and never sells your data.')
@section('content')
    <div class="bg-white dark:bg-gray-900">
        <x-page-hero
            title="About Ediary"
            subtitle="Our mission is to provide the safest, simplest, and most private space for your personal reflections."
        />

        <!-- Content Section -->
        <div class="container mx-auto max-w-4xl px-4 py-16">
            <div class="text-gray-700 dark:text-gray-300">
                <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">The Story Behind Ediary</h2>
                <p class="mb-6 leading-relaxed">
                    Ediary was born from a simple belief: everyone deserves a private place to think. In an age where
                    every click is tracked and every thought is often shared, the traditional diary remains one of the
                    few truly private spaces left.
                </p>
                <p class="mb-6 leading-relaxed">
                    We wanted to bring that classic experience into the digital world—making it accessible from anywhere
                    while ensuring it remains as private as a locked book under your bed.
                </p>

                <div class="my-16 grid gap-12 md:grid-cols-2">
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Privacy First</h3>
                        <p>
                            We don't sell your data and we don't show ads. Your entries are encrypted at rest and
                            private by default. Read how it works on our
                            <a
                                href="{{ url('/security') }}"
                                class="text-primary-600 dark:text-primary-400 hover:underline"
                                >security page</a
                            >.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Simplicity Always</h3>
                        <p>
                            Journaling shouldn't be a chore. We focus on a clean, distraction-free interface that lets
                            you focus on what matters: your thoughts.
                        </p>
                    </div>
                </div>

                <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Built for the Future</h2>
                <p class="mb-6 leading-relaxed">
                    Using modern web technology, Ediary works perfectly on your phone, tablet, or desktop. With offline
                    support, you can capture a moment in the middle of a forest or on a plane, and it will safely sync
                    when you're back online.
                </p>
            </div>

            @include('blogs._cta')
        </div>
    </div>
@endsection
