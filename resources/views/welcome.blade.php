@extends('layouts.app')
@section('title','Home | Document your life with privacy friendly Web App')
@push('meta')
    @include('includes.meta')
@endpush
@section('content')
<div class="flex flex-col px-3 md:px-6 bg-blue-700 text-gray-200">
    <div class="flex flex-col justify-center items-center min-h-screen">
        <h1 class="text-4xl sm:block md:text-5xl text-center">Easiest way to document your life</h1>
        <h2 class="text-xl md:text-2xl mb-4 text-center">Free service to keep track of your past and think about your
            future.</h2>
        @guest
        <register-form></register-form>
        @endguest
    </div>
    <div class="mt-6 border border-dashed rounded-lg p-2 md:p-6 mb-4">
        <h2 class="text-4xl text-gray-200 mb-2 text-center">Features</h2>
        <div class="flex text-gray-200 justify-center flex-wrap items-stretch">
            <div class="feature p-4 mb-2">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="mr-1 feather feather-shield" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>Enjoy Complete Privacy
                </h3>
                <p class="sm:w-96">At Ediary, your privacy is our top priority. We prioritize your privacy by refraining from asking for unnecessary details like your name or date of birth. Rest assured, we only require your email address for verification purposes.</p>
            </div>
            <div class="feature p-4">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock mr-1">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>Keep Your Thoughts Secure
                </h3>
                <p class="sm:w-96">Your diary entries are treated with utmost confidentiality. Each entry is encrypted and securely stored in our database, ensuring that only you can access and read them. Relax and express yourself freely, knowing your words are protected.</p>
            </div>
            <div class="feature p-4">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 feather feather-wifi-off">
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                        <path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55"></path>
                        <path d="M5 12.55a10.94 10.94 0 0 1 5.17-2.39"></path>
                        <path d="M10.71 5.05A16 16 0 0 1 22.58 9"></path>
                        <path d="M1.42 9a15.91 15.91 0 0 1 4.7-2.88"></path>
                        <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                        <line x1="12" y1="20" x2="12.01" y2="20"></line>
                    </svg>Never Miss a Moment
                </h3>
                <p class="sm:w-96">With Ediary, you have the freedom to capture your thoughts anytime, even when you're offline. If you find yourself without an internet connection, your entries are automatically saved on your device. As soon as you reconnect to the internet, they seamlessly sync with your diary. Stay connected to your diary, no matter where you are.</p>
            </div>
            <div class="feature p-4">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>Effortless Access, Anytime
                </h3>
                <p class="sm:w-96">Enhance your diary experience by adding Ediary to your Home Screen. By doing so, you can effortlessly access your diary with a single tap, just like using a native app. Enjoy the convenience of instant entry and seamless navigation.</p>
            </div>
        </div>
    </div>
    <h2 class="text-2xl underline p-4 font-bold">Latest Articles</h2>
    <div class="flex flex-col md:flex-row gap-4 p-4">
        <div class="w-full h-auto bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white lg:block lg:w-1/2 bg-cover rounded-lg p-4 m-1">
            <h2 class="font-bold text-lg"><a href="{{route('blogs.how-to-write')}}">How to write a Diary</a></h2>
            <cite class="uppercase text-xs font-bold text-gray-700 dark:text-gray-300">Written By</cite> <a class="uppercase text-xs font-bold text-gray-700 dark:text-gray-300" href="https://www.wikihow.com/Write-a-Diary">WikiHow</a>
            <p>Diaries are wonderful objects that allow you to discuss your emotions, record dreams or ideas, and
                reflect
                on
                daily life in a safe, private space. While there's no single, definitive way to write a diary, there are
                some
                basic tricks you can use to get the most out of your writing. If you aren't sure what to write about,
                using
                prompts like inspirational quotes can help get started on new entries. <a href="{{route('blogs.how-to-write')}}" class="text-blue-600">read more...</a></p>
        </div>
        <div class="w-full h-auto bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white lg:block lg:w-1/2 bg-cover rounded-lg p-4 m-1">
            <h2 class="font-bold text-lg"><a href="{{route('blogs.these-8-good-things')}}">These 8
                    Good Things Will
                    Happen When You Start Writing Diaries</a></h2>
            <cite class="uppercase text-xs font-bold text-gray-700 dark:text-gray-300">Written By</cite> <a class="uppercase text-xs font-bold text-gray-700 dark:text-gray-300" href="#">INTERNET BLOGGER</a>
            <p>Writing to yourself is an important means of self-expression. Whether you call it a diary or refer to it
                as
                a journal, having a place to write down your thoughts, feelings, memories and personal impressions about
                life can be healing and teach you to know yourself better. It can also unlock the power of your
                creativity,
                and inspire you to manifest dreams <a href="{{route('blogs.these-8-good-things')}}" class="text-blue-600">read
                    more...</a></p>
        </div>
        <div class="w-full h-auto bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white lg:block lg:w-1/2 bg-cover rounded-lg p-4 m-1">
            <h2 class="font-bold text-lg"><a href="{{route('blogs.how-to-start-writing-a-diary')}}">How to Start Writing a Diary</a>
            </h2>
            <cite class="uppercase text-xs font-bold text-gray-700 dark:text-gray-300">Written By</cite> <a class="uppercase text-xs font-bold text-gray-700 dark:text-gray-300" href="https://shakiltech.com">Shakil Alam</a>
            <p>To start a diary, all you need is a willingness to write. Start by figuring out what you want
                to write in your journal.
                If you are not sure, simply start writing and see where that leads. It can also be useful to set a time
                limit
                in your
                early writing sessions. Set an alarm for 10 to 20 minutes and start writing. <a href="{{route('blogs.how-to-start-writing-a-diary')}}" class="text-blue-600">read
                    more...</a></p>
        </div>
    </div>
</div>
@endsection
