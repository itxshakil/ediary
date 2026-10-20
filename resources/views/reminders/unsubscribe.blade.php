@extends('layouts.app')
@section('title', $done ? 'Reminders are off' : 'Turn off reminders')
@section('robots', 'noindex, nofollow')
@section('content')
    <div class="container mx-auto max-w-lg px-4 py-16">
        <x-card class="text-center">
            @if ($done)
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Reminders are off</h1>
                <p class="mt-3 text-gray-600 dark:text-gray-400">
                    We won't send evening reminders any more. You can turn them back on in Settings at any time.
                </p>
                <x-button href="{{ url('/settings') }}" variant="secondary" class="mt-6">Open Settings</x-button>
            @else
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Turn off reminders?</h1>
                <p class="mt-3 text-gray-600 dark:text-gray-400">
                    You'll stop getting evening emails nudging you to write. Your diary stays exactly as it is.
                </p>
                <form method="POST" action="{{ request()->fullUrl() }}" class="mt-6">
                    @csrf
                    <x-button type="submit">Turn off reminders</x-button>
                </form>
            @endif
        </x-card>
    </div>
@endsection
