@extends('layouts.app')
@section('title','Change Your Ediary Password')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex my-6">
        <div class="w-full h-auto hidden lg:block lg:w-1/2 bg-cover rounded-l-lg bg-blue-700">
            <div class="flex flex-col text-gray-200 justify-center items-center">
                <div class="feature p-4 mb-1">
                    <h3 class="mb-2 text-xl flex flex-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-wifi-off">
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                            <path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55"></path>
                            <path d="M5 12.55a10.94 10.94 0 0 1 5.17-2.39"></path>
                            <path d="M10.71 5.05A16 16 0 0 1 22.58 9"></path>
                            <path d="M1.42 9a15.91 15.91 0 0 1 4.7-2.88"></path>
                            <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                            <line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>Availability
                    </h3>
                    <p class="w-96">When You aren't connected to the Internet(Offline). Then we save your entry in your
                        device and sync back to the database when the connection back to the Internet.</p>
                </div>
                <div class="feature p-4 mb-1">
                    <h3 class="mb-2 text-xl flex flex-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>Installable
                    </h3>
                    <p class="w-96">For easy access, you can add Ediary to your Home Screen. So you can use it as native
                        apps.</p>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 bg-gray-200 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h3 class="pt-4 text-2xl text-center pb-2 md:pb-4">Change Your Username!</h3>
            <form class="px-4 md:px-8  pt-6 pb-2 mb-4 bg-white rounded" method="POST" action="/username">
                <section class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="username">
                        Username
                    </label>
                    <username-input @error('email') :iserror="true" @enderror value="{{auth()->user()->username}}">
                    </username-input>
                    @error('username')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </section>
                <section class="mb-4 text-center">
                    <button
                        class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
                        type="submit">
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
