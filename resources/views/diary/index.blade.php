@extends('layouts.app')
@section('title','Add new Entry')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6 my-12">
    <div class="entries flex flex-wrap items-stretch">
        @forelse ($diaries as $diary)
            <div class="card w-64 bg-gray-100 pb-2 md:p-5 p-2 m-4 shadow-lg rounded overflow-hidden">
            <p>{{$diary->entry}}</p>
            </div>
            @empty
            <p>No Entry add new</p>
        @endforelse
    </div>
</div>
@endsection