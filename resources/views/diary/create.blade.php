@extends('layouts.app')

@section('title', 'Add new Entry')

@section('content')
    <div class="container mx-auto max-w-5xl px-4 py-8">
        <div class="mb-6">
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
            >
                <span aria-hidden="true">←</span>
                Back to dashboard
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
            <div>
                <x-diary-form
                    form-id="create-diary-form"
                    title="Write your next entry"
                    description="Use the same fast writing flow from the home page, with your drafts and offline support intact."
                />
            </div>

            <aside class="space-y-4">
                <div class="rounded-2xl border border-gray-200/70 bg-white p-6 shadow-[0_1px_2px_rgba(0,0,0,0.05)] dark:border-gray-700/60 dark:bg-gray-900">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Quick tips</h2>
                    <ul class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-300">
                        <li>Give the entry a title when you want to find it faster later.</li>
                        <li>Use tags for themes like work, gratitude, travel, or goals.</li>
                        <li>Press <span class="font-semibold">Ctrl</span> or <span class="font-semibold">Cmd</span> + <span class="font-semibold">Enter</span> to submit quickly.</li>
                    </ul>
                </div>

                <div class="rounded-2xl border border-blue-200/70 bg-linear-to-br from-blue-50 to-white p-6 shadow-[0_1px_2px_rgba(0,0,0,0.05)] dark:border-blue-900/40 dark:from-blue-950/30 dark:to-gray-900">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Works offline</h2>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                        If you lose connection while writing, Ediary keeps the draft locally and syncs it when you are back online.
                    </p>
                </div>
            </aside>
        </div>
    </div>
@endsection
