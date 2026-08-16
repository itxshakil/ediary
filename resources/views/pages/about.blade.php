@extends('layouts.app')
@section('title', 'About E-diary App')
@section('content')
    <div class="bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-blue-600 py-20">
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute inset-0"
                    style="
                        background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0);
                        background-size: 40px 40px;
                    "
                ></div>
            </div>
            <div class="relative container mx-auto px-4 text-center">
                <h1 class="mb-6 text-4xl font-extrabold text-white md:text-6xl">About Ediary</h1>
                <p class="mx-auto max-w-2xl text-xl text-blue-100">
                    Our mission is to provide the safest, simplest, and most private space for your personal
                    reflections.
                </p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="container mx-auto max-w-4xl px-4 py-16">
            <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
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
                            We don't sell your data. We don't even look at it. Your entries are encrypted, meaning only
                            you have the keys to your memories.
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
