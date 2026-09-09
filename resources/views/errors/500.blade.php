@extends('errors.layout')

@section('title', 'Something went wrong')
@section('tone', 'danger')
@section('code', '500')
@section('eyebrow', "We've been notified")
@section('heading', 'A page tore loose')
@section('description', "Something broke on our end, not yours. It's already been logged, and we're on it.")

@section('actions')
    <a href="{{ url('/') }}" class="error-btn error-btn-primary">Go home</a>
    <a href="{{ url('/contact') }}" class="error-btn error-btn-secondary">Contact support</a>
@endsection

@section('details')
    <summary>Technical details</summary>
    <div class="error-details-body">
        <p>If you contact support, this reference helps us find exactly what happened.</p>
        <dl>
            <dt>Reference</dt>
            <dd>{{ request()->header(\App\Http\Middleware\RequestLogger::X_REQUEST_ID, 'unavailable') }}</dd>
            <dt>Time</dt>
            <dd>{{ now()->toDayDateTimeString() }}</dd>
        </dl>
    </div>
@endsection
