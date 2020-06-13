@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 md:px-6 my-12">
    <div class="flex justify-center items-center">
        @can('update', $profile)
        <profile :data="{{$profile->toJson()}}" :can-edit="true"></profile>
        @else
        <profile :data="{{$profile->toJson()}}" :can-edit="false"></profile>
        @endcan
    </div>
</div>
@endsection