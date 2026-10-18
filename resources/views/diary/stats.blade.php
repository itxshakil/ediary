@extends('layouts.app')
@section('title', 'Your Writing Stats')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Your stats</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Your writing habits, moods, and milestones at a glance.
                </p>
            </div>

            <a
                href="{{ route('diary.create') }}"
                class="bg-primary-600 hover:bg-primary-700 inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium text-white shadow-sm transition"
            >
                <span>New entry</span>
            </a>
        </div>

        <x-dashboard :stats="$stats" />
    </div>
@endsection
