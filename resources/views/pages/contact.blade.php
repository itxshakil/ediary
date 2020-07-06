@extends('layouts.app')
@section('title','Contact Us')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6">
        <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800')">
        </div>
        <div class="w-full lg:w-1/2 bg-gray-200 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h3 class="pt-4 text-2xl text-center pb-6 md:pb-4">Contact us!</h3>
            <form class="px-3 md:px-8 pb-2 mb-4 bg-white rounded" method="POST"
                action="{{ route('contact.send') }}">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                        Name
                    </label>
                    <input
                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('name') border-red-500 @enderror"
                        id="name" type="text" placeholder="John Doe" name="name" value="{{ old('name') }}" required
                        autocomplete="name" autofocus />
                    @error('name')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                        Email address
                    </label>
                    <input
                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror"
                        id="email" type="email" placeholder="john@example.com" name="email" value="{{ old('email') }}"
                        required autocomplete="email" autofocus />
                    @error('email')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="message">
                        Message
                    </label>
                    <resizable-textarea>
                        <textarea
                            class="w-full px-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('message') border-red-500 @enderror"
                            name="message" id="message" cols="30" rows="10"
                            placeholder="Bug report/ Feature request/Suggestion and more..." required autofocus
                            value="{{old('message')}}"></textarea>
                    </resizable-textarea>
                    @error('message')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 text-center">
                    <button
                        class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none uppercase shadow hover:shadow-md font-bold text-xs"
                        type="submit">
                        Send
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection