@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6">
        <div class="w-full h-auto hidden lg:block lg:w-1/2 bg-cover rounded-l-lg bg-blue-700">
            <div class="flex flex-col h-full text-gray-200 justify-center items-center">
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
            <h1 class="pt-4 text-2xl text-center pb-2 md:pb-4 text-gray-900 dark:text-white">{{ __('Reset Password') }}
            </h1>
            <div class="px-4 md:px-8  pt-6 pb-2 mb-4 bg-white rounded">
                @if (session('status'))
                <div class="border px-4 py-3 my-2 rounded w-64 bg-green-100 text-green-700 border-green-400" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="email">
                            {{ __('E-Mail Address') }}
                        </label>
                        <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 dark:text-gray-200 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror" id="email" type="email" placeholder="john@example.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        @error('email')
                        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4 text-center">
                        <button class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none" type="submit">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
