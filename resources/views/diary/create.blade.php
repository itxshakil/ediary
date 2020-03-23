@extends('layouts.app')
@section('title','Add new Entry')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex">
        {{-- <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800')">
        </div> --}}
        <div class="w-full bg-gray-100 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h3 class="pt-4 text-2xl text-center pb-2 md:pb-4">Add new entry!</h3>
            <form class="px-8 pt-6 pb-2 mb-4 bg-white rounded" method="POST" action="{{ route('diary.store') }}">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="entry">
                        Entry
                    </label>
                    <resizable-textarea>
                        <textarea class="notebook w-full px-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('entry') border-red-500 @enderror" name="entry" id="entry" cols="30" rows="10" placeholder="Its was an awesome day today." required autofocus value="{{old('entry')}}"></textarea>
                    </resizable-textarea>
                    @error('entry')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 text-center">
                    <button
                        class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        Save
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection