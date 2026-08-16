@extends('layouts.app')
@section('title', 'Change Your Ediary Password')
@section('content')
    <div class="container mx-auto flex justify-center px-3 md:px-6">
        <div class="my-6 flex w-full lg:w-11/12 xl:w-3/4">
            <div class="hidden h-auto w-full rounded-l-lg bg-blue-700 bg-cover lg:block lg:w-1/2">
                <div class="flex flex-col items-center justify-center text-gray-200">
                    <div class="feature mb-1 p-4">
                        <h3 class="flex-center mb-2 flex text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-wifi-off">
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                                <path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55"></path>
                                <path d="M5 12.55a10.94 10.94 0 0 1 5.17-2.39"></path>
                                <path d="M10.71 5.05A16 16 0 0 1 22.58 9"></path>
                                <path d="M1.42 9a15.91 15.91 0 0 1 4.7-2.88"></path>
                                <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                                <line x1="12" y1="20" x2="12.01" y2="20"></line>
                            </svg
                            >Availability
                        </h3>
                        <p class="w-96">
                            When You aren't connected to the Internet(Offline). Then we save your entry in your device
                            and sync back to the database when the connection back to the Internet.
                        </p>
                    </div>
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
                <h3 class="pt-4 pb-2 text-center text-2xl text-gray-900 md:pb-4 dark:text-white">
                    Change Your Username!
                </h3>
                <form
                    class="mb-4 rounded-sm bg-white px-4 pt-6 pb-2 md:px-8 dark:bg-gray-900 dark:text-white"
                    method="POST"
                    action="/username"
                >
                    <section class="mb-4">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="username">
                            Username
                        </label>
                        <username-input
                            @error('email') :iserror="true" @enderror
                            value="{{ auth()->user()->username }}"
                        ></username-input>
                        @error('username')
                            <p class="text-xs text-red-500 italic" role="alert">{{ $message }}</p>
                        @enderror
                    </section>
                    <section class="mb-4 text-center">
                        <button
                            class="mr-2 mb-1 w-full rounded-full bg-blue-500 px-3 py-2 text-xs font-bold text-white uppercase shadow-sm outline-hidden hover:shadow-md focus:outline-hidden active:bg-blue-800 sm:px-4"
                            type="submit"
                        >
                            Save
                        </button>
                    </section>
                    @csrf
                    @method('PUT')
                </form>
            </div>
        </div>
    </div>
@endsection
