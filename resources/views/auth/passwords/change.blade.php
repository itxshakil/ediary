@extends('layouts.app')
@section('title','Change your Password')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6">
        <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800')">
        </div>
        <div class="w-full lg:w-1/2 bg-gray-200 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h1 class="pt-4 text-2xl text-center pb-2 md:pb-4 text-gray-900">{{ __('Change Password') }}</h1>
            <form class="px-4 md:px-8  pt-6 pb-2 mb-4 bg-white rounded" method="POST"
                action="{{ route('password.change') }}">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="current-password">
                        {{ __('Current Password') }}
                    </label>
                    <input
                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror"
                        id="current-password" type="password" placeholder="**********" name="current-password" required
                        autocomplete="current-password" autofocus />
                    @error('current-password')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                        {{ __('New Password') }}
                    </label>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('password') border-red-500 @enderror"
                        id="password" type="password" name="password" value="{{old('password')}}"
                        autocomplete="new-password" placeholder="******************" />
                    @error('password')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="password_confirmation">
                        {{ __('Confirm New Password') }}
                    </label>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('password_confirmation') border-red-500 @enderror"
                        id="password_confirmation" type="password" name="password_confirmation"
                        autocomplete="new-password" placeholder="******************" />
                    @error('password_confirmation')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 text-center">
                    <button
                        class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none uppercase shadow hover:shadow-md font-bold text-xs"
                        type="submit">
                        {{ __('Change Password') }}
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection