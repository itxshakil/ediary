@extends('layouts.app')
@section('title')
{{$profile->name}} 's Profile Page
@endsection
@section('content')
<div class="container mx-auto px-3 md:px-6">
    <div class="flex justify-center items-center">
        @can('update', $profile)
        <profile :data="{{$profile->toJson()}}" :can-edit="true"></profile>
        @else
        <profile :data="{{$profile->toJson()}}" :can-edit="false" :is-following="{{$isFollowing ? "true" :"false" }}">
        </profile>
        @endcan
    </div>
</div>
@endsection
