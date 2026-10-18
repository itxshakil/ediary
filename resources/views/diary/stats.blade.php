@extends('layouts.app')
@section('title', 'Your Writing Stats')
@section('content')
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <x-page-header title="Your stats" subtitle="Your writing habits, moods, and milestones at a glance.">
            <x-slot:actions>
                <x-button href="{{ route('diary.create') }}">New entry</x-button>
            </x-slot:actions>
        </x-page-header>

        <x-dashboard :stats="$stats" />
    </div>
@endsection
