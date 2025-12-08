@extends('layouts.app')

@section('title','Request/Download your data')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-12
            bg-gray-100 dark:bg-gray-900 w-full max-w-xl mx-auto">

        <div class="bg-white dark:bg-gray-800
                rounded-3xl shadow-xl
                p-6 sm:p-10">

            <h3 class="text-2xl font-semibold text-center mb-6
                   text-gray-900 dark:text-white">
                {{ __('Request Data') }}
            </h3>

            <div class="bg-gray-50 dark:bg-gray-900
                    border border-gray-200 dark:border-gray-700
                    rounded-2xl p-6 space-y-4">

                <div class="rounded-xl px-4 py-3 text-sm
                        bg-yellow-50 text-yellow-800 border border-yellow-200
                        dark:bg-yellow-900/20 dark:text-yellow-300 dark:border-yellow-700/40"
                     role="alert">
                    Click the button below to download your data, including your
                    profile information and diary entries.
                </div>

                <form method="POST" action="{{ route('request.data') }}">
                    @csrf

                    <button type="submit"
                            class="w-full h-11 rounded-full
                               bg-blue-600 hover:bg-blue-700
                               text-white text-sm font-medium
                               transition active:scale-[0.98]
                               focus:outline-none focus:ring-4 focus:ring-blue-500/30">
                        {{ __('Download My Data') }}
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
