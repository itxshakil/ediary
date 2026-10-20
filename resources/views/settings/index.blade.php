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
                        Your username appears in your profile link. You can sign in with it or with your email.
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
                <form method="POST" action="{{ route('settings.reminders') }}">
                    @csrf
                    @method('PUT')

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Email reminders</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        A short nudge around 8 pm your time on days you haven't written. Never more than one a day, and
                        never with your entries in it.
                    </p>

                    <label class="mt-4 flex items-center gap-3 text-sm text-gray-800 dark:text-gray-200">
                        <input
                            type="checkbox"
                            name="reminders_enabled"
                            value="1"
                            @checked(old('reminders_enabled', auth()->user()->reminders_enabled))
                            class="text-primary-600 focus:ring-primary-500 h-4 w-4 rounded border-gray-300"
                        />
                        Send me evening reminders
                    </label>

                    <label for="timezone" class="mt-4 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Your timezone
                    </label>
                    <div class="mt-2 flex flex-col gap-3 sm:flex-row">
                        @php
                            $currentZone = old('timezone', auth()->user()->localTimezone());
                            // Keep a legacy alias someone already has (e.g. Asia/Calcutta) selectable.
                            $zones = collect(DateTimeZone::listIdentifiers())->push($currentZone)->unique()->sort();
                        @endphp
                        <select id="timezone" name="timezone" class="field">
                            @foreach ($zones as $zone)
                                <option value="{{ $zone }}" @selected($currentZone === $zone)>
                                    {{ str_replace('_', ' ', $zone) }}
                                </option>
                            @endforeach
                        </select>
                        <x-button type="submit" class="sm:w-auto">Save reminders</x-button>
                    </div>
                    <x-form.error name="timezone" />
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
