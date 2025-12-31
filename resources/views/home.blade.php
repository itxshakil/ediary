@extends('layouts.app')
@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div>
                <x-streak-counter
                    :streak="$streak"
                    :longestStreak="$longestStreak"
                    :todayWritten="$todayWritten"
                />
            </div>
            <div class="lg:col-span-2">
                <x-diary-form />
            </div>
        </div>

        <x-search-component />

        <div class="space-y-4">
            @foreach($entries as $entry)
                <x-diary-card :entry="$entry" />
            @endforeach
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
