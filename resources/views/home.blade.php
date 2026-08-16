@extends('layouts.app')
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

        <x-search-component />

        <div class="space-y-4">
            @foreach ($entries as $entry)
                <x-diary-card :entry="$entry" />
            @endforeach
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
