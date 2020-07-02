@extends('layouts.app')
@section('title','Verify Your Email Address')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex">
        <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-center bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800')">
        </div>
        <div class="w-full lg:w-1/2 bg-gray-100 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h3 class="pt-4 text-2xl text-center pb-2 md:pb-4">{{ __('Verify Your Email Address') }}</h3>
            <div class="px-4 md:px-8  pt-6 pb-2 mb-4 bg-white rounded">
                @if (session('resent'))
                <div class="border px-4 py-3 my-2 rounded w-full bg-green-100 text-green-700 border-green-400"
                    role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
                @endif
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <div class="mb-4 text-center">
                        <button
                            class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none mr-2 my-2 uppercase shadow hover:shadow-md font-bold text-xs"
                            type="submit">{{ __('Click here to request another') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection