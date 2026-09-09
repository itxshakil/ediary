@extends('errors.layout')

@section('title', 'Down for maintenance')
@section('tone', 'neutral')
@section('code', '503')
@section('eyebrow', 'Maintenance')
@section('heading', "We're tidying up")
@section('description', 'Ediary is briefly offline for scheduled maintenance. This usually takes a few minutes — try refreshing shortly.')

@section('head')
    <meta http-equiv="refresh" content="60" />
@endsection

@section('actions')
    <a href="{{ url()->current() }}" class="error-btn error-btn-primary">Refresh</a>
@endsection
