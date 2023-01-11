@extends('layouts.app')
@section('title','Frequently Asked Questions')
@section('content')
<div class="container mx-auto px-3 md:px-6">
    <h1 class="text-xl md:text-2xl mt-4">Frequently Asked Questions and Answers:</h1>
    <p class="hidden md:block">This is a shortlist of our most frequently asked questions. For more information about
        E-diary, or if you need support, please visit our support center. </p>

    <h3 class="font-semibold mt-4">What is E-diary?</h3>
    <p class="ml-2 mb-2">E-diary is a <strong>free</strong> service to keep track of your past and think about your
        future. You can make predictions about what will happen and see if they come true, and you can see how you
        changed over time, and read over memories, having a few laughs. It's the funniest, quickest, and easiest way to document your life
        through a series of notes. Tap down a note or a thought on your notebook, mobile phone, or tablet and transform
        it into a memory to keep around forever. </p>

    <h3 class="font-semibold mt-4">How can I create a diary?</h3>
    <p class="ml-2 mb-2">You need to register with a unique username and password (<a href="/register"
            class="text-blue-700">Sign up</a>)</p>

    <h3 class="font-semibold mt-4">How can I print my entries?</h3>
    <p class="ml-2 mb-2">You have to <a href="/request-data" class="text-blue-700">request here</a> and then we will
        send you all your data
        to your email. You can then
        unzip this file and print as many as you'd like. You may also print any diary entries directly from the web
        browser.</p>

    <h3 class="font-semibold mt-4">Who can see my entries?</h3>
    <p class="ml-2 mb-2">All entries are private by default which means they are not visible or can not be read by
        anyone without <a href="/login" class="text-blue-70">login</a> for the same diary.</p>

    <h3 class="font-semibold mt-4">How does privacy work?</h3>
    <p class="ml-2 mb-2">Privacy with us is very simple. Nobody can read your notes, except yourself. Nothing is "public" by default on E-diary. Also, your all entries are saved in the database in encrypted form. So no one can read except you..</p>

    <h3 class="font-semibold mt-4">How did the idea come about?</h3>
    <p class="ml-2 mb-2">We like to be melancholy, writing daily notes, and reading them over. We always assumed taking
        interesting notes required big bulky paper books. But as mobile phones got better and better, smaller and
        smaller, we decided to challenge that assumption. We created E-diary to solve three simple problems:
        <ol class="list-decimal list-inside">
            <li class="pl-2">Traditional paper diaries not in your pocket at all times. An online and mobile diary makes
                it almost
                always accessible.</li>
            <li class="pl-2">Making copies and backup your paper diary is a pain - write a note once, then access it
                (instantly)
                on multiple services.</li>
            <li class="pl-2">Most diary experiences are clumsy and take forever - we've optimized the experience to be
                fast and
                efficient.</li>
        </ol>
    </p>

    <h3 class="font-semibold mt-4">Why I am asked to give my email address?</h3>
    <p class="ml-2 mb-2">You can use this email later for resetting your password.</p>
</div>
@endsection
