@extends('layouts.app')
@section('title', 'Your journal')
@section('content')
    <div class="container mx-auto max-w-7xl px-4 py-8">
        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="flex flex-col gap-4">
                <x-streak-counter :streak="$streak" :longestStreak="$longestStreak" :todayWritten="$todayWritten" />
                <x-mood-chart :moodData="$moodData" />
            </div>
            <div class="lg:col-span-2">
                <x-diary-form />
            </div>
        </div>

        {{-- Nothing to search before the first entry. --}}
        @if ($entries->total() > 0)
            <x-search-component />
        @endif

        <div class="space-y-4">
            @forelse ($entries as $entry)
                <x-diary-card :entry="$entry" />
            @empty
                <x-empty-state
                    title="Your first entry is just for you"
                    body="Entries are private unless you choose to share them. Write a few lines about today, or tap “Use this prompt” above to get started."
                />
            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
