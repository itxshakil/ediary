@extends('layouts.app')
@section('title','Add new Entry')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6">
        {{-- <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800'); background-position: center center;">
        </div> --}}
        <div class="w-full bg-gray-100 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h3 class="pt-4 text-2xl text-center pb-2 md:pb-4 text-gray-900 dark:text-white">Add new entry!</h3>
            <form class="px-4 md:px-8  pt-6 pb-2 mb-4 bg-white dark:text-white dark:bg-gray-900 rounded-sm" method="POST" action="{{ route('diary.store') }}">
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="entry">
                        Entry
                    </label>
                    <div data-vue-root>
                    <resizable-textarea>
                        <textarea class="notebook w-full px-3 text-sm leading-tight text-gray-700 border rounded-sm shadow-sm appearance-none focus:outline-hidden @error('entry') border-red-500 @enderror" name="entry" id="entry" cols="30" rows="10" placeholder="Its was an awesome day today." required autofocus value="{{old('entry')}}"></textarea>
                    </resizable-textarea>
                    </div>
                    @error('entry')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 text-center">
                    <button class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-hidden" type="submit">
                        Save
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
