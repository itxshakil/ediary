@extends('layouts.app')
@section('title')
Latest Blog Article
@endsection
@section('content')
<div class="container mx-auto px-3 md:px-6">
    <div class="rounded-lg bg-gray-400 p-4 text-center mt-2">
        @auth
        <a class="bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-lg outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            href="/home">Start writing Now</a>
        @else
        <a class="bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-lg outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            href="/login">Start Writing now</a>
        @endauth
    </div>
    <h1 class="text-2xl underline p-4 font-bold">Latest Articles</h1>
    <div class="flex flex-col md:flex-row gap-4 p-4 text-gray-900">
        <div class="w-full h-auto bg-gray-400 lg:block lg:w-1/2 bg-cover rounded-lg p-4 m-1">
            <h2 class="font-bold text-lg"><a href="/blogs/how-to-write-diary">How to write a Diary</a></h2>
            <cite class="uppercase text-xs font-bold">Written By</cite> <a class="uppercase text-xs font-bold"
                href="https://www.wikihow.com/Write-a-Diary">WikiHow</a>
            <p>Diaries are wonderful objects that allow you to discuss your emotions, record dreams or ideas, and
                reflect
                on
                daily life in a safe, private space. While there's no single, definitive way to write a diary, there are
                some
                basic tricks you can use to get the most out of your writing. If you aren't sure what to write about,
                using
                prompts like inspirational quotes can help get started on new entries. <a
                    href="/blogs/how-to-write-diary" class="text-blue-600">read more...</a></p>
        </div>
        <div class="w-full h-auto bg-gray-400 lg:block lg:w-1/2 bg-cover rounded-lg p-4 m-1">
            <h2 class="font-bold text-lg"><a
                    href="/blogs/these-8-good-things-will-happen-when-you-start-writing-diary">These 8
                    Good Things Will
                    Happen When You Start Writing Diaries</a></h2>
            <cite class="uppercase text-xs font-bold">Written By</cite> <a class="uppercase text-xs font-bold"
                href="#">INTERNET BLOGGER</a>
            <p>Writing to yourself is an important means of self-expression. Whether you call it a diary or refer to it
                as
                a journal, having a place to write down your thoughts, feelings, memories and personal impressions about
                life can be healing and teach you to know yourself better. It can also unlock the power of your
                creativity,
                and inspire you to manifest dreams <a
                    href="/blogs/these-8-good-things-will-happen-when-you-start-writing-diary"
                    class="text-blue-600">read
                    more...</a></p>
        </div>
        <div class="w-full h-auto bg-gray-400 lg:block lg:w-1/2 bg-cover rounded-lg p-4 m-1">
            <h2 class="font-bold text-lg"><a href="/blogs/how-to-start-writing-a-diary">How to Start Writing a Diary</a>
            </h2>
            <cite class="uppercase text-xs font-bold">Written By</cite> <a class="uppercase text-xs font-bold"
                href="#">Shakil Alam</a>
            <p>To start a diary, all you need is a willingness to write. Start by figuring out what you want
                to write in your journal.
                If you aren’t sure, simply start writing and see where that leads. It can also be useful to set a time
                limit
                in your
                early writing sessions. Set an alarm for 10 to 20 minutes and start writing. <a
                    href="/blogs/how-to-start-writing-a-diary" class="text-blue-600">read
                    more...</a></p>
        </div>
    </div>
    <div class="rounded-lg bg-gray-400 p-4 text-center mb-2">
        @auth
        <a class="bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-lg outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            href="/home">Start writing Now</a>
        @else
        <a class="bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-lg outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            href="/login">Start Writing now</a>
        @endauth
    </div>
</div>
@endsection
