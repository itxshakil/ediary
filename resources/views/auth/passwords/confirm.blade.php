@extends('layouts.app')
@section('title', 'Confirm your Password')
@section('content')
    <div class="container mx-auto flex justify-center px-3 md:px-6">
        <div class="my-6 flex w-full lg:w-11/12 xl:w-3/4">
            <div class="hidden h-auto w-full rounded-l-lg bg-blue-700 bg-cover lg:block lg:w-1/2">
                <div class="flex h-full flex-col items-center justify-center text-gray-200">
                    <div class="feature mb-1 p-4">
                        <h3 class="flex-center mb-2 flex text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg
                            >Installable
                        </h3>
                        <p class="w-96">
                            For easy access, you can add Ediary to your Home Screen. So you can use it as native apps.
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-full rounded-lg bg-gray-200 p-2 md:p-5 lg:w-1/2 lg:rounded-l-none dark:bg-gray-800">
                <h1 class="pt-4 pb-2 text-center text-2xl text-gray-900 md:pb-4 dark:text-white">
                    {{ __('Confirm Password') }}
                </h1>
                <div class="mb-4 rounded-sm bg-white px-4 pt-6 pb-2 md:px-8">
                    <p>{{ __('Please confirm your password before continuing.') }}</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <div class="flex items-baseline justify-between">
                                <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="password">
                                    {{ __('Password') }}
                                </label>
                                @if (Route::has('password.request'))
                                    <a
                                        class="mr-2 mb-2 block text-xs font-semibold text-blue-700"
                                        href="{{ route('password.request') }}"
                                    >
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            <input
                                class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded-sm shadow-sm appearance-none focus:outline-hidden @error('password') border-red-500 @enderror"
                                id="password"
                                type="password"
                                name="password"
                                placeholder="******************"
                            />
                            @error('password')
                                <p class="text-xs text-red-500 italic" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 text-center">
                            <button
                                class="w-full rounded-full bg-blue-500 px-3 py-2 text-xs font-bold text-white uppercase shadow-sm outline-hidden hover:shadow-md focus:outline-hidden active:bg-blue-800 sm:px-4"
                                type="submit"
                            >
                                {{ __('Confirm Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
