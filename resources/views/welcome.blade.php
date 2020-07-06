@extends('layouts.app')
@section('title','Ediary')
@section('content')
<div class="flex flex-col px-3 md:px-6 bg-blue-700 text-gray-200">
    <div class="flex flex-col justify-center items-center min-h-screen">
        <h2 class="text-2xl hidden md:block md:text-4xl text-center">Your own secure and private E-diary</h2>
        <p class="text-xl md:text-2xl mb-4 text-center">Your diary is the only friend, with whom you can share all your secrets and thoughts without hesitation.</p>
        @guest
        <register-form></register-form>
        @endguest
    </div>
    <div class="mt-6 border border-dashed rounded-lg p-2 md:p-6 mb-4">
        <h2 class="text-4xl text-gray-200 mb-2 text-center">Features</h2>
        <div class="flex text-gray-200 justify-center flex-wrap items-stretch">
            <div class="feature p-4 mb-2">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="mr-1"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-shield">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>Privacy
                </h3>
                <p class="sm:w-96">We respect your privacy. That's why we don't ask for any personal details such as Your
                    name, Date of birth, etc. We ask
                    for your Email-address for verification purposes only.</p>
            </div>
            <div class="feature p-4">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-lock">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>Secure
                </h3>
                <p class="sm:w-96">Your all entries in the diary are private by default. We save your entry in encrypted
                    form in the Database. So no one
                    can read it except you.</p>
            </div>
            <div class="feature p-4">
                <h3 class="mb-2 text-xl flex items-center">
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
                <p class="sm:w-96">Sometime you may not have an internet connection to save your entries then we will
                    save your entries in your device and
                    when you connected to the Internet we save it to your diary. So you can add entries when you're
                    offline.</p>
            </div>
            <div class="feature p-4">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" class="mr-1" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>Installable
                </h3>
                <p class="sm:w-96">You can add Ediary to your Home Screen. So you can access your diary easily. You can use
                    it as native apps.</p>
            </div>
        </div>
    </div>
</div>
@endsection