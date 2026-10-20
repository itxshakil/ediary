@extends('layouts.app')
@section('title', 'Add new Entry')
@section('content')
    <div class="container mx-auto max-w-2xl px-4 py-8">
        <x-page-header title="New entry" subtitle="What's on your mind today?" />

        <x-card>
            <form method="POST" action="{{ route('diary.store') }}" data-entry-form>
                @csrf

                @include('diary._fields', ['entry' => null])

                <p data-offline-note class="mb-3 hidden text-center text-xs text-yellow-600 dark:text-yellow-400">
                    You're offline. Your entry will be saved on this device and synced when you're back online.
                </p>
                <x-button size="lg" type="submit" class="w-full">Save entry</x-button>
            </form>
        </x-card>
    </div>
@endsection
