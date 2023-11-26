@extends('layouts.app')
@section('title','Confirm your Password')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6">
        <div class="w-full h-auto hidden lg:block lg:w-1/2 bg-cover rounded-l-lg bg-blue-700">
            <div class="flex h-full flex-col text-gray-200 justify-center items-center">
                <div class="feature p-4 mb-1">
                    <h3 class="mb-2 text-xl flex flex-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>Installable
                    </h3>
                    <p class="w-96">For easy access, you can add Ediary to your Home Screen. So you can use it as native
                        apps.</p>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 bg-gray-200 dark:bg-gray-800 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h1 class="pt-4 text-2xl text-center pb-2 md:pb-4 text-gray-900 dark:text-white">{{ __('Confirm Password') }}
            </h1>
            <div class="px-4 md:px-8  pt-6 pb-2 mb-4 bg-white rounded">
                <p>{{ __('Please confirm your password before continuing.') }}</p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4">
                        <div class="flex justify-between items-baseline">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="password">
                                {{ __('Password') }}
                            </label>
                            @if (Route::has('password.request'))
                            <a class="block mb-2 text-xs mr-2 font-semibold text-blue-700" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                        <input class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('password') border-red-500 @enderror" id="password" type="password" name="password" placeholder="******************" />
                        @error('password')
                        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 text-center">
                        <button class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none uppercase shadow hover:shadow-md font-bold text-xs" type="submit">
                            {{ __('Confirm Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
