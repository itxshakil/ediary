@extends('layouts.app')
@section('title', 'Your Entries')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <x-page-header title="Your entries" subtitle="Browse everything you've written, newest first.">
            <x-slot:actions>
                <x-button href="{{ route('diary.create') }}">New entry</x-button>
            </x-slot:actions>
        </x-page-header>

        <div class="space-y-4">
            @forelse ($entries as $entry)
                <x-diary-card :entry="$entry" />
            @empty
                <x-empty-state
                    title="No entries yet"
                    body="Your journal is empty. Write your first entry; it's private unless you choose to share it."
                >
                    <x-slot:action>
                        <x-button href="{{ route('diary.create') }}">Write your first entry</x-button>
                    </x-slot:action>
                </x-empty-state>
            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
