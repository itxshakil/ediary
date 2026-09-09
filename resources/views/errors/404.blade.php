@extends('errors.layout')

@section('title', 'Page not found')
@section('tone', 'neutral')
@section('code', '404')
@section('eyebrow', 'Page not found')
@section('heading', 'This page slipped out of the diary')
@section('description', "We couldn't find " . e(request()->path()) . '. It may have been moved, renamed, or never existed.')

@section('body')
    <form class="error-search" action="{{ route('search') }}" method="get">
        <label
            for="q"
            class="sr-only"
            style="position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0)"
        >Search Ediary</label>
        <input id="q" type="search" name="q" placeholder="Search entries, people, or tags…" autocomplete="off" />
    </form>
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="error-btn error-btn-primary">Go home</a>
    <a href="{{ url('/blog') }}" class="error-btn error-btn-secondary">Read the blog</a>
@endsection

@section('extra')
    <h2 class="error-extra-heading">Where you might have meant to go</h2>
    <div class="suggestion-grid">
        <a href="{{ url('/') }}" class="suggestion-card">
            <span class="suggestion-card-label">Start</span>
            <span class="suggestion-card-title">Home</span>
        </a>
        <a href="{{ url('/blog') }}" class="suggestion-card">
            <span class="suggestion-card-label">Read</span>
            <span class="suggestion-card-title">Blog articles</span>
        </a>
        <a href="{{ url('/about') }}" class="suggestion-card">
            <span class="suggestion-card-label">Learn</span>
            <span class="suggestion-card-title">About Ediary</span>
        </a>
        <a href="{{ url('/faq') }}" class="suggestion-card">
            <span class="suggestion-card-label">Help</span>
            <span class="suggestion-card-title">FAQ</span>
        </a>
        <a href="{{ url('/contact') }}" class="suggestion-card">
            <span class="suggestion-card-label">Reach out</span>
            <span class="suggestion-card-title">Contact support</span>
        </a>
        @auth
            <a href="{{ route('diary.create') }}" class="suggestion-card">
                <span class="suggestion-card-label">Write</span>
                <span class="suggestion-card-title">New diary entry</span>
            </a>
        @else
            <a href="{{ route('register') }}" class="suggestion-card">
                <span class="suggestion-card-label">Join</span>
                <span class="suggestion-card-title">Create an account</span>
            </a>
        @endauth
    </div>

    <h2 class="error-extra-heading" style="margin-top: 2.5rem">While you're here</h2>
    <div class="tip-carousel" tabindex="0" role="group" aria-label="Journaling tips">
        <div class="tip-slide">
            "Write one true sentence" — start an entry with the simplest, most honest thing that happened today.
        </div>
        <div class="tip-slide">
            Tag your entries by mood. Ediary's mood chart turns a week of tags into a pattern you can actually see.
        </div>
        <div class="tip-slide">Private by default. Only entries you explicitly share ever leave your account.</div>
    </div>
@endsection
