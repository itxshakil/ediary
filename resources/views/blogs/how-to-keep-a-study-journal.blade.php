@extends('layouts.blog-post')

@section('article')
    <p class="text-xl leading-relaxed font-medium text-gray-600 italic md:text-2xl dark:text-gray-400">
        Notes record what the lecturer said. A study journal records what you understood, what you didn't, and what to
        do next.
    </p>

    <p>
        Most students take plenty of notes and still feel lost at revision time. The missing piece is reflection: a few
        minutes after each session where you write down, in your own words, where you stand. That short habit is what a
        study journal is for.
    </p>

    <h2>Why a study journal works</h2>
    <p>
        Explaining something in your own words forces you to notice the gaps. Writing "I still don't get why the
        integral changes sign" is far more useful than a page of copied formulas, because it tells future you exactly
        where to start.
    </p>
    <p>
        A journal also gives you a record over time. When exams arrive you can scroll back through weeks of entries and
        see which topics kept coming up as confusing, instead of guessing.
    </p>

    <h2>What to write after each session</h2>
    <p>Keep it short. Five minutes is enough. Answer these questions:</p>
    <ul>
        <li><strong>What did I cover?</strong> One or two lines, not a summary of the whole chapter.</li>
        <li><strong>What clicked?</strong> The idea that finally made sense, in your own words.</li>
        <li><strong>What is still fuzzy?</strong> Be specific. Name the exact step or concept.</li>
        <li>
            <strong>What will I do next?</strong> One concrete action, like "redo problem 4" or "ask in the seminar".
        </li>
        <li><strong>How did it feel?</strong> Focused, tired, anxious? Patterns here matter more than you think.</li>
    </ul>

    <h2>A five-minute template</h2>
    <p>Copy this into a new entry after you study:</p>
    <ul>
        <li><strong>Course:</strong> (use it as a tag, for example #biology)</li>
        <li><strong>Covered:</strong></li>
        <li><strong>Clicked:</strong></li>
        <li><strong>Still fuzzy:</strong></li>
        <li><strong>Next step:</strong></li>
        <li><strong>Energy and mood:</strong></li>
    </ul>
    <p>That's it. Some entries will be two lines long and that's fine. Consistency beats length.</p>

    <h2>Organise by course with tags</h2>
    <p>
        Tag every entry with its course or module. When revision starts, open one tag and you have the full history of
        that subject: what you learned, in what order, and where you struggled. In E-diary you can tap any tag on an
        entry to see every entry with that tag.
    </p>

    <h2>Use it at revision time</h2>
    <ol>
        <li>Open the tag for the subject you're revising.</li>
        <li>Read only the "still fuzzy" lines. That's your revision list.</li>
        <li>Cross off the ones you now understand, and write a new entry about the ones you don't.</li>
    </ol>
    <p>
        You'll often find that something you were stuck on in week three is obvious now. That's a confidence boost too.
    </p>

    <h2>Keep the habit going</h2>
    <ul>
        <li><strong>Attach it to something you already do.</strong> Write the entry before you close your laptop.</li>
        <li>
            <strong>Don't wait for Wi-Fi.</strong> Use a journal that works offline so the library or the train isn't an
            excuse.
        </li>
        <li>
            <strong>Keep it private.</strong> You'll be more honest about what you don't understand if nobody else can
            read it.
        </li>
        <li><strong>Watch your streak.</strong> A visible streak is a small but real motivator.</li>
    </ul>

    <h2>Getting started</h2>
    <p>
        Pick tonight's study session and write one entry using the template above. If you want a place for it,
        <a href="{{ url('/for-students') }}">E-diary is free for students</a>, works offline, and keeps every entry
        private by default.
    </p>
@endsection
