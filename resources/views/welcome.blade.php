@extends('layouts.app')
@section('title','Ediary - Securely Document Your Life, Free & Effortless')
@push('meta')
    @include('includes.meta')
@endpush
@section('content')
<div class="flex flex-col px-3 md:px-6 bg-blue-700 text-gray-200">
    <div class="flex flex-col justify-center items-center min-h-screen max-w-4xl mx-auto">
        <h1 class="text-4xl max-w-3xl sm:block md:text-5xl text-center text-pretty">Capture Your Life’s Journey: Secure, Private, and Effortless</h1>
        <h2 class="text-xl md:text-2xl mb-4 text-center mt-2">
            <strong>Struggling to keep track of your thoughts and memories?</strong> Start documenting your life with Ediary—a safe haven for your innermost reflections, accessible anytime, anywhere.
        </h2>
        @guest
        <register-form></register-form>
        @endguest
    </div>
    <div class="mt-6 border border-dashed rounded-lg p-2 md:p-4 mb-4 max-w-5xl mx-auto">
        <h2 class="text-4xl text-gray-200 mb-2 text-center">Features</h2>
        <div class="flex text-gray-200 justify-center flex-wrap items-stretch">
            <div class="feature p-4 mb-2">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="mr-1 feather feather-shield" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>Complete Privacy, Guaranteed
                </h3>
                <p class="sm:w-96">Your secrets are safe with Ediary. We don’t ask for unnecessary details like your name or date of birth—just your email for verification. Your privacy isn’t just a feature; it’s our promise.</p>
            </div>
            <div class="feature p-4">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock mr-1">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>Ironclad Security for Your Thoughts
                </h3>
                <p class="sm:w-96">Every word you write is encrypted and stored securely. Your diary is for your eyes only—no one else can access it. Write freely, knowing your deepest reflections are locked away, safe and sound.</p>
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
                    </svg>Capture Every Moment, Anywhere
                </h3>
                <p class="sm:w-96">Don’t let life’s best moments slip away. Write whenever inspiration strikes—even offline. Your entries auto-save to your device and sync effortlessly when you’re back online. Your diary is always with you, no matter where life takes you.</p>
            </div>
            <div class="feature p-4">
                <h3 class="mb-2 text-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>Instant Access, Hassle-Free
                </h3>
                <p class="sm:w-96">Add Ediary to your Home Screen and access your journal with a single tap. It’s fast, seamless, and feels just like a native app. Start writing in seconds, with zero distractions.</p>
            </div>
        </div>
    </div>
    <section class="max-w-5xl mx-auto">
        <h2 class="text-2xl underline p-4 font-bold">Latest Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            <div class="w-full h-auto bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white lg:block bg-cover rounded-lg p-4 m-1">
                <h2 class="font-bold text-lg"><a href="{{route('blogs.goal-setting-for-success')}}">5 Steps to Design the Life You’ve Always Dreamed Of</a></h2>
                <cite class="uppercase text-xs font-bold text-gray-700 dark:text-gray-300">Written By</cite> <a class="uppercase text-xs font-bold text-gray-700 dark:text-gray-300" href="https://shakiltech.com">Shakil Alam</a>
                <p>Ready to turn your goals into achievements? Learn the best strategies for setting clear, actionable goals that lead to real success. Start planning your future today. <a href="{{route('blogs.goal-setting-for-success')}}" class="text-blue-600">read more...</a></p>
            </div>
            <div class="w-full h-auto bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white lg:block bg-cover rounded-lg p-4 m-1">
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
            <div class="w-full h-auto bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white lg:block bg-cover rounded-lg p-4 m-1 md:col-span-2">
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
        </div>
    </section>
</div>
@endsection
