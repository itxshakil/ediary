@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
    <div class="container mx-auto max-w-5xl px-4 py-8">
        <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <section class="rounded-2xl border border-gray-200/70 bg-white p-6 shadow-[0_1px_2px_rgba(0,0,0,0.05)] dark:border-gray-700/60 dark:bg-gray-900">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600 dark:text-blue-400">
                    Settings
                </p>
                <h1 class="mt-3 text-3xl font-semibold text-gray-900 dark:text-white">Change your username</h1>
                <p class="mt-4 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                    Update the public name people use to find your profile. Your existing routes and account stay the same, but your profile URL and future mentions will use the new username.
                </p>

                <div class="mt-6 rounded-2xl border border-blue-200/70 bg-blue-50/70 p-4 text-sm text-blue-900 dark:border-blue-900/40 dark:bg-blue-950/30 dark:text-blue-100">
                    Pick something memorable, between 5 and 25 characters, using letters, numbers, dashes, or underscores.
                </div>
            </section>

            <section class="rounded-2xl border border-gray-200/70 bg-white p-6 shadow-[0_1px_2px_rgba(0,0,0,0.05)] dark:border-gray-700/60 dark:bg-gray-900">
                <form method="POST" action="{{ url('/username') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-form.label for="username">Username</x-form.label>
                        <x-form.input
                            id="username"
                            name="username"
                            :value="auth()->user()->username"
                            placeholder="your-username"
                            autocomplete="username"
                            required
                        />

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            This updates the username shown on your profile and anywhere your account is referenced.
                        </p>

                        @error('username')
                            <p class="mt-2 text-sm text-red-500" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a
                            href="{{ route('home') }}"
                            class="text-sm font-medium text-gray-500 transition hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        >
                            Cancel and go back
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                        >
                            Save username
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
