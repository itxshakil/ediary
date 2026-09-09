@extends('errors.layout')

@section('title', 'Too many requests')
@section('tone', 'warning')
@section('code', '429')
@section('eyebrow', 'Slow down')
@section('heading', "You're moving faster than we can keep up")
@section('description', "You've made too many requests in a short time. Give it a moment and try again.")

@section('body')
    <div class="retry-ring" aria-hidden="true"><span>~30s</span></div>
@endsection

@section('actions')
    <a href="{{ url()->previous('/') }}" class="error-btn error-btn-primary">Try again</a>
    <a href="{{ url('/') }}" class="error-btn error-btn-secondary">Go home</a>
@endsection
