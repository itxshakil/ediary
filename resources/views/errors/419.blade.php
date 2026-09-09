@extends('errors.layout')

@section('title', 'Page expired')
@section('tone', 'warning')
@section('code', '419')
@section('eyebrow', 'Page expired')
@section('heading', 'Your session took a nap')
@section('description', "This page had been open too long and its security token expired. Go back and try submitting again — your entry usually isn't lost.")

@section('actions')
    <a
        href="{{ url()->previous('/') }}"
        class="error-btn error-btn-primary"
        onclick="
            if (history.length > 1) {
                history.back();
                return false;
            }
        "
    >Go back</a>
    <a href="{{ url('/') }}" class="error-btn error-btn-secondary">Go home</a>
@endsection

@section('details')
    <summary>What happened?</summary>
    <div class="error-details-body">
        <p>
            Every form on Ediary carries a one-time security token (CSRF protection) that expires after a period of
            inactivity or when your session cookie is cleared. It's a safeguard against other sites submitting forms on
            your behalf without you noticing.
        </p>
        <p>Reloading the previous page usually issues a fresh token and lets you submit right away.</p>
    </div>
@endsection
