@extends('layouts.app')
@section('title', $mood->label() . ' Entries')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <x-page-header
            :title="$mood->emoji() . ' ' . $mood->label()"
            :subtitle="trans_choice('{1} 1 entry|[0,*] :count entries', $entries->total()) . ' where you felt ' . mb_strtolower($mood->label()) . ', newest first.'"
        >
            <x-slot:actions>
                <x-button variant="secondary" href="{{ url('/diaries') }}">All entries</x-button>
            </x-slot:actions>
        </x-page-header>

        <div class="space-y-4">
            @forelse ($entries as $entry)
                <x-diary-card :entry="$entry" />
            @empty
                <x-empty-state
                    :title="'No ' . mb_strtolower($mood->label()) . ' entries yet'"
                    body="Pick a mood when you write an entry and you'll be able to look back on it here."
                />
            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
