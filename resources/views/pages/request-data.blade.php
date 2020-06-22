@extends('layouts.app')
@section('title','Request your data')
@section('content')
<div class="container mx-auto flex justify-center items-center h-64 px-3 md:px-6 my-12">
    <div class="w-full lg:w-1/2 bg-gray-100 p-2 md:p-5 rounded-lg">
        <h3 class="pt-4 text-2xl text-center pb-2 md:pb-4">{{ __('Request Data') }}</h3>
        <div class="px-4 md:px-8  pt-6 pb-2 mb-4 bg-white rounded">
            <div class="border px-4 py-3 my-2 rounded w-full bg-yellow-100 text-yellow-700 border-yellow-400"
                role="alert">
                Click Below button to download your Data , that includes Your Profile Data and Your Diary.
            </div>
            <form method="POST" action="{{ route('request.data') }}">
                @csrf
                <div class="mb-4 text-center">
                    <button
                        class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        {{ __('Download My Data') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection