@extends('layouts.blog-post')

@section('article')
    <p class="text-xl leading-relaxed font-medium text-gray-600 italic md:text-2xl dark:text-gray-400">
        The hardest part of journaling is the blank page. Pick one prompt, set a timer for five minutes, and write
        whatever comes.
    </p>

    <p>
        There are no right answers. Don't edit, don't worry about grammar, and don't write for anyone else. If a prompt
        doesn't fit, skip it.
    </p>

    <h2>Study reflection</h2>
    <ol>
        <li>What is one thing I understand today that I didn't understand last week?</li>
        <li>Which topic am I avoiding, and why?</li>
        <li>If I had to teach today's lesson to a friend, where would I get stuck?</li>
        <li>What study method actually worked for me this week? What didn't?</li>
        <li>Where was I most focused today, and what was different about it?</li>
        <li>What question would I ask my lecturer if I weren't worried about how it sounds?</li>
        <li>What is one small thing I can do tomorrow to make studying easier?</li>
        <li>Which course do I enjoy most right now, and what does that tell me?</li>
    </ol>

    <h2>Exam stress</h2>
    <ol start="9">
        <li>What exactly am I worried will happen? Write it out in detail.</li>
        <li>What is in my control before this exam, and what isn't?</li>
        <li>When have I handled something like this before? What helped?</li>
        <li>What would I say to a friend who felt the way I feel right now?</li>
        <li>What does a realistic, good-enough outcome look like?</li>
        <li>How am I sleeping, eating, and moving this week? What would help?</li>
        <li>What will I do to reward myself when this exam is over?</li>
        <li>Three things that went well today, however small.</li>
    </ol>

    <h2>Motivation and goals</h2>
    <ol start="17">
        <li>Why did I choose this course in the first place? Is that still true?</li>
        <li>Where do I want to be in a year, and what is one step toward it this week?</li>
        <li>What is something I'm proud of that nobody else noticed?</li>
        <li>What drains my energy, and what refills it?</li>
        <li>What would I do this weekend if I weren't afraid of falling behind?</li>
        <li>What skill outside my course do I want to build?</li>
        <li>What does a good day look like for me as a student?</li>
        <li>What am I procrastinating on, and what is the smallest first step?</li>
    </ol>

    <h2>Friends, home, and everything else</h2>
    <ol start="25">
        <li>Who made my week better, and have I told them?</li>
        <li>Where do I feel most like myself on campus or at school?</li>
        <li>What do I miss about home, and what do I like about being away?</li>
        <li>Is there a conversation I've been avoiding? What would I say?</li>
        <li>How am I spending my money, and does it match what I value?</li>
        <li>What have I learned about myself from living with other people?</li>
        <li>What does rest look like for me, honestly?</li>
        <li>What is something new I tried recently, and how did it go?</li>
    </ol>

    <h2>End of semester review</h2>
    <ol start="33">
        <li>What were my three biggest wins this semester?</li>
        <li>What was harder than I expected, and what did I learn from it?</li>
        <li>Which habits helped me most? Which do I want to drop?</li>
        <li>Which module surprised me, for better or worse?</li>
        <li>How have I changed since the start of the semester?</li>
        <li>What advice would I give myself on the first day of this semester?</li>
        <li>What do I want to do differently next semester?</li>
        <li>What am I grateful for right now?</li>
    </ol>

    <h2>Make it a habit</h2>
    <p>
        Keep your prompts somewhere you'll see them, and write at the same time each day, for example right after your
        last study session. Tag your entries, like #exams or #reflection, so you can look back on a theme later. If you
        want a private place to write,
        <a href="{{ url('/for-students') }}">Ediary is free for students</a>, works offline, and keeps every entry
        private by default. For a structured daily habit, try our
        <a href="/blogs/how-to-keep-a-study-journal">study journal template</a>.
    </p>
@endsection
