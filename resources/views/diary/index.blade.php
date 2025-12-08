@extends('layouts.app')
@section('title','Add new Entry')
@section('content')
<div class="container mx-auto px-3 md:px-6 my-12">
    <div class="entries flex flex-wrap items-stretch">
        <div data-vue-root>
            <diaries></diaries>
        </div>
        {{-- @foreach ($diaries as $diary)
        <div class="card w-64 bg-gray-100 pb-2 md:p-5 p-2 m-4 shadow-lg rounded-sm overflow-hidden">
            <p>{{$diary->entry}}</p>
    </div>
    @endforeach --}}
</div>
{{$diaries->links()}}
</div>
@endsection
