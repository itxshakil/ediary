@extends('layouts.blog-post')

@section('article')
    <p class="text-xl leading-relaxed font-medium text-gray-600 italic md:text-2xl dark:text-gray-400">
        Six months from now you won't remember why you dropped that variable or changed your sampling. Your research
        journal will.
    </p>

    <p>
        A research journal is a dated, running record of your project: what you did, what you decided, and why. It's
        different from a lab notebook, which records procedures and results. The journal records your thinking.
    </p>

    <h2>Research journal vs lab notebook</h2>
    <ul>
        <li><strong>Lab notebook:</strong> protocols, measurements, results. Often formal and sometimes required.</li>
        <li>
            <strong>Research journal:</strong> reasoning, doubts, decisions, ideas, and how the work is going for you.
        </li>
    </ul>
    <p>
        Many researchers keep both. If your field has no lab notebook, the journal becomes your main record of how the
        project evolved.
    </p>

    <h2>What to write</h2>
    <h3>Decisions and the reasons behind them</h3>
    <p>
        "Switched from interviews to a survey because recruitment stalled at six participants." Decisions like this are
        exactly what examiners ask about, and the reasoning is the first thing you forget.
    </p>

    <h3>Dead ends</h3>
    <p>
        Write down approaches that didn't work and why. It stops you repeating them, and it is useful material for the
        limitations section of your thesis.
    </p>

    <h3>Ideas you aren't ready to act on</h3>
    <p>
        A half-formed idea written down today can become a chapter later. If it stays in your head, it is usually gone
        by next week.
    </p>

    <h3>Reading reactions</h3>
    <p>
        After a paper, write two or three lines on what it changes for your project. These notes make your literature
        review far easier to draft than a pile of highlighted PDFs.
    </p>

    <h3>How you're doing</h3>
    <p>
        Research is long and often isolating. A line about your energy and mood each time helps you notice when you're
        stuck or burning out, before it becomes a crisis.
    </p>

    <h2>How often to write</h2>
    <p>
        Aim for a short entry on every day you work on the project, even if it's just "read two papers, nothing new".
        Regular small entries beat occasional long ones, because the point is the record over time.
    </p>

    <h2>A simple entry structure</h2>
    <ul>
        <li><strong>Today I:</strong> what you actually did.</li>
        <li><strong>I decided:</strong> any decision, with the reason.</li>
        <li><strong>I'm unsure about:</strong> open questions.</li>
        <li><strong>Next:</strong> the next concrete step.</li>
        <li><strong>Tags:</strong> chapter, method, or theme, like #methods or #chapter-2.</li>
    </ul>

    <h2>How it pays off</h2>
    <ul>
        <li><strong>Supervisor meetings:</strong> scan the last two weeks of entries and you have your agenda.</li>
        <li><strong>Methods chapter:</strong> your decisions and reasons are already written down, in order.</li>
        <li><strong>Viva or defence:</strong> you can explain why you did things, not just what you did.</li>
        <li><strong>Your wellbeing:</strong> you can see progress on weeks when it feels like there is none.</li>
    </ul>

    <h2>Choosing where to keep it</h2>
    <p>
        Your journal will hold unpublished ideas and honest doubts, so privacy matters. It also needs to be there when
        you are: in the archive, the field, or on a train. Look for something private by default, searchable, taggable,
        that works offline and lets you export everything.
        <a href="{{ url('/for-students') }}">E-diary</a> does all of that for free, and our
        <a href="{{ url('/security') }}">security page</a> explains exactly how entries are protected.
    </p>
@endsection
