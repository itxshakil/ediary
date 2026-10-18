@extends('layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="container mx-auto max-w-3xl px-4 py-8">
        <x-page-header title="Settings" subtitle="Manage your account and your data." />

        <div class="space-y-6">
            <x-card>
                <form method="POST" action="{{ url('/username') }}">
                    @csrf
                    @method('PUT')

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Username</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Your username is used to sign in and appears in your profile link.
                    </p>

                    <label for="username" class="sr-only">Username</label>
                    <div class="mt-4 flex flex-col gap-3 sm:flex-row">
                        <input
                            id="username"
                            name="username"
                            type="text"
                            value="{{ old('username', auth()->user()->username) }}"
                            required
                            minlength="5"
                            maxlength="25"
                            pattern="[A-Za-z0-9_\-]+"
                            autocomplete="username"
                            spellcheck="false"
                            aria-describedby="username-help"
                            class="field"
                            @error('username') aria-invalid="true" @enderror
                        />
                        <x-button type="submit" class="sm:w-auto">Save username</x-button>
                    </div>
                    @error('username')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400" role="alert">{{ $message }}</p>
                    @else
                        <p id="username-help" class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            5 to 25 characters: letters, numbers, dashes and underscores.
                        </p>
                    @enderror
                </form>
            </x-card>

            <x-card>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Password</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choose a new password for your account.</p>
                <x-button variant="secondary" href="{{ url('/password/change') }}" class="mt-4"
                    >Change password</x-button>
            </x-card>

            <x-card>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Your data</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Download every entry you've written. Your journal is yours to keep.
                    <a href="{{ url('/security') }}" class="text-primary-600 dark:text-primary-400 underline"
                        >How we protect it</a>
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <x-button variant="secondary" href="{{ route('diary.export', ['format' => 'csv']) }}"
                        >Export as CSV</x-button>
                    <x-button variant="secondary" href="{{ route('diary.export', ['format' => 'json']) }}"
                        >Export as JSON</x-button>
                    <x-button variant="ghost" href="{{ url('/request-data') }}">Email me a copy</x-button>
                </div>
            </x-card>

            <x-card>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Use Ediary like an app</h2>
                <ul class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                    <li>
                        <strong class="text-gray-900 dark:text-white">Works offline.</strong>
                        Entries you write without a connection are saved on this device and sync when you're back
                        online.
                    </li>
                    <li>
                        <strong class="text-gray-900 dark:text-white">Install it.</strong>
                        Add Ediary to your home screen from your browser's menu for one-tap access.
                    </li>
                </ul>
            </x-card>
        </div>
    </div>
@endsection
