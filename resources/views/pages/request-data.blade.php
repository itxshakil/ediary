@extends('layouts.app')

@section('title', 'Request/Download your data')

@section('content')
    <div class="mx-auto flex min-h-screen w-full max-w-xl items-center justify-center bg-gray-100 px-4 py-12 dark:bg-gray-900">
        <div class="rounded-3xl bg-white p-6 shadow-xl sm:p-10 dark:bg-gray-800">
            <h3 class="mb-6 text-center text-2xl font-semibold text-gray-900 dark:text-white">
                {{ __('Request Data') }}
            </h3>

            <div class="space-y-4 rounded-2xl border border-gray-200 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-900">
                <div
                    class="rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800 dark:border-yellow-700/40 dark:bg-yellow-900/20 dark:text-yellow-300"
                    role="alert"
                >
                    Click the button below to download your data, including your profile information and diary entries.
                </div>

                <form method="POST" action="{{ route('request.data') }}">
                    @csrf

                    <button
                        type="submit"
                        class="h-11 w-full rounded-full bg-blue-600 text-sm font-medium text-white transition hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 focus:outline-none active:scale-[0.98]"
                    >
                        {{ __('Download My Data') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
