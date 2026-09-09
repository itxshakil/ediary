@extends('errors.layout')

@section('title', 'Access denied')
@section('tone', 'warning')
@section('code', '403')
@section('eyebrow')
    Access denied
    <span class="info-wrap">
        <button type="button" class="info-trigger" popovertarget="why-403" aria-label="Why am I seeing this?">?</button>
        <div id="why-403" class="info-tooltip" popover role="tooltip">
            You're signed in, but this page belongs to someone else or requires a permission your account doesn't have.
            If that seems wrong, contact support.
        </div>
    </span>
@endsection
@section('heading', 'This page is kept private')
@section('description', "You don't have permission to view this. If you think that's a mistake, sign in with a different account or reach out to support.")

@section('actions')
    <a href="{{ url('/') }}" class="error-btn error-btn-primary">Go home</a>
    @guest
        <a href="{{ route('login') }}" class="error-btn error-btn-secondary">Sign in</a>
    @else
        <a href="{{ url('/contact') }}" class="error-btn error-btn-secondary">Contact support</a>
    @endguest
@endsection
