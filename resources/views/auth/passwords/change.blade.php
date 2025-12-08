@extends('layouts.app')

@section('title','Change your Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-12
            bg-gray-100 dark:bg-gray-900">

        <div class="w-full max-w-4xl">
            <div class="flex overflow-hidden rounded-3xl
                    bg-white dark:bg-gray-800
                    shadow-xl">

                @include('auth.partials.left-branding')

                <div class="w-full lg:w-1/2 p-8 sm:p-12">

                    <div class="mb-8 text-center">
                        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">
                            Change Password
                        </h1>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Update your account security
                        </p>
                    </div>

                    <form method="POST"
                          action="{{ route('password.change') }}"
                          class="space-y-6">

                        @csrf

                        <div>
                            <x-form.label for="current-password">Current Password</x-form.label>
                            <x-form.input id="current-password" type="password" name="current-password" autocomplete="current-password" />
                            @error('current-password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.label for="password">Password</x-form.label>
                            <x-form.input id="password" type="password" name="password" autocomplete="new-password" />
                            @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.label for="password_confirmation">Confirm Password</x-form.label>
                            <x-form.input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" />
                            @error('password_confirmation')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-button.primary class="w-full">Change Password</x-button.primary>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
