{{-- Feature landing pages from config/landing-pages.php. --}}
@extends('layouts.app')
@section('title', $page['headline'])
@section('description', $page['meta_description'])

@php
    $prompts = config("journal-prompts.pages.{$page['related']['prompts']}");
    $post = config("blog.posts.{$page['related']['post']}");
@endphp

@section('content')
    <div class="bg-white dark:bg-gray-900">
        <x-page-hero :title="$page['title']" :subtitle="$page['subtitle']" :eyebrow="$page['eyebrow']">
            @auth
                <a
                    href="{{ route('diary.create') }}"
                    class="text-primary-700 hover:bg-primary-50 inline-block rounded-xl bg-white px-8 py-3 text-sm font-bold uppercase shadow-md transition"
                >Write an entry</a>
            @else
                <a
                    href="{{ route('register') }}"
                    class="text-primary-700 hover:bg-primary-50 inline-block rounded-xl bg-white px-8 py-3 text-sm font-bold uppercase shadow-md transition"
                >{{ $page['cta'] }}</a>
                <p class="text-primary-200 mt-4 text-sm">Free. Just an email, no name or phone number.</p>
            @endauth
        </x-page-hero>

        <section class="container mx-auto max-w-5xl px-4 py-16">
            <h2 class="mb-10 text-center text-3xl font-bold text-gray-900 dark:text-white">How people use it</h2>
            <div class="grid gap-8 md:grid-cols-3">
                @foreach ($page['uses'] as $use)
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">{{ $use['title'] }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $use['body'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-gray-50 py-16 dark:bg-gray-800/50">
            <div class="container mx-auto max-w-4xl px-4">
                <h2 class="mb-10 text-center text-3xl font-bold text-gray-900 dark:text-white">Why Ediary</h2>
                <ul class="grid gap-6 text-gray-700 md:grid-cols-2 dark:text-gray-300">
                    @foreach ($page['features'] as $feature)
                        <li>
                            <strong class="text-gray-900 dark:text-white">{{ $feature['title'] }}</strong>
                            {{ $feature['body'] }}
                        </li>
                    @endforeach
                </ul>
                <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    <a href="{{ url('/security') }}" class="text-primary-600 dark:text-primary-400 underline"
                        >How Ediary protects your entries</a>
                </p>
            </div>
        </section>

        <section class="container mx-auto max-w-4xl px-4 py-16">
            <h2 class="mb-10 text-center text-3xl font-bold text-gray-900 dark:text-white">Start in under a minute</h2>
            <ol class="grid gap-8 md:grid-cols-3">
                @foreach ($page['steps'] as $step)
                    <li class="text-center">
                        <span class="bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full font-bold">{{ $loop->iteration }}</span>
                        <p class="text-gray-700 dark:text-gray-300">{{ $step }}</p>
                    </li>
                @endforeach
            </ol>
        </section>

        <section class="bg-gray-50 py-16 dark:bg-gray-800/50">
            <div class="container mx-auto max-w-3xl px-4">
                <h2 class="mb-8 text-center text-3xl font-bold text-gray-900 dark:text-white">Questions</h2>
                <div class="space-y-6">
                    @foreach ($page['faqs'] as $faq)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $faq['q'] }}</h3>
                            <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $faq['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="container mx-auto max-w-5xl px-4 py-16">
            <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Keep reading</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @include('journal-prompts._card', ['slug' => $page['related']['prompts'], 'page' => $prompts, 'heading' => 'h3'])
                @include('blogs._card', ['slug' => $page['related']['post'], 'post' => $post, 'heading' => 'h3'])
            </div>

            @include('blogs._cta')
        </section>
    </div>
@endsection
