@extends('layouts.app')
@section('title', 'Explore Public Diary Entries')
@section('description', 'Read diary entries that Ediary writers have chosen to share publicly. Every entry is private by default, so these were shared on purpose.')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <x-page-header
            title="Explore"
            subtitle="Entries people have chosen to share. Everything is private by default."
        />

        <div class="space-y-4">
            @forelse ($entries as $entry)
                <x-diary-card :entry="$entry" :show-owner="true" />
            @empty
                <x-empty-state
                    title="Nothing shared yet"
                    body="When someone makes an entry public, it will show up here."
                />
            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
