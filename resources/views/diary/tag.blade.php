@extends('layouts.app')
@section('title', '#' . $tag . ' Entries')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <x-page-header
            :title="'#' . $tag"
            :subtitle="trans_choice('{1} 1 entry tagged #:tag|[0,*] :count entries tagged #:tag', $entries->total(), ['tag' => $tag]) . ', newest first.'"
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
                    :title="'No entries tagged #' . $tag"
                    body="Add this tag to an entry and it will show up here."
                />
            @endforelse
        </div>

        <x-diary-paginator :collection="$entries" />
    </div>
@endsection
