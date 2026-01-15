@extends('layouts.app')
@section('title','About E-diary App')
@section('content')
<div class="bg-white dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="relative py-20 overflow-hidden bg-blue-600">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="container mx-auto px-4 relative text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6">About Ediary</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Our mission is to provide the safest, simplest, and most private space for your personal reflections.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mx-auto px-4 py-16 max-w-4xl">
        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">The Story Behind Ediary</h2>
            <p class="mb-6 leading-relaxed">
                Ediary was born from a simple belief: everyone deserves a private place to think. In an age where every click is tracked and every thought is often shared, the traditional diary remains one of the few truly private spaces left.
            </p>
            <p class="mb-6 leading-relaxed">
                We wanted to bring that classic experience into the digital world—making it accessible from anywhere while ensuring it remains as private as a locked book under your bed.
            </p>

            <div class="grid md:grid-cols-2 gap-12 my-16">
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Privacy First</h3>
                    <p>We don't sell your data. We don't even look at it. Your entries are encrypted, meaning only you have the keys to your memories.</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Simplicity Always</h3>
                    <p>Journaling shouldn't be a chore. We focus on a clean, distraction-free interface that lets you focus on what matters: your thoughts.</p>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Built for the Future</h2>
            <p class="mb-6 leading-relaxed">
                Using modern web technology, Ediary works perfectly on your phone, tablet, or desktop. With offline support, you can capture a moment in the middle of a forest or on a plane, and it will safely sync when you're back online.
            </p>
        </div>

        @include('blogs._cta')
    </div>
</div>
@endsection
