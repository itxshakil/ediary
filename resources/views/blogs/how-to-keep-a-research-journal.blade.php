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

    <h2>Two example entries</h2>
    <blockquote>
        #methods #chapter-3. Today I: coded interviews 6 and 7. I decided: merge "time pressure" and "workload" into one
        code, because participants use the words interchangeably. I'm unsure about: whether that hides a difference
        between students and staff. Next: check the staff interviews for the distinction before Friday.
    </blockquote>
    <blockquote>
        #literature. Today I: read a 2021 paper on survey fatigue. Reaction: their response-rate drop matches what I saw
        in my pilot; could justify the shorter questionnaire. Unsure: their sample was all undergraduates. Next: look
        for a postgraduate study before citing it as support.
    </blockquote>
    <p>
        Neither entry took more than five minutes, and both answer a question a supervisor or examiner is likely to ask
        months later: why did you do it that way?
    </p>

    <h2>Weekly and monthly reviews</h2>
    <p>
        Once a week, read back your entries and write a short summary: what moved forward, what's blocked, and what you
        decided. Once a month, read the weekly summaries. This is where the research journal earns its keep: patterns
        appear, such as a method that keeps causing problems or a theme that keeps resurfacing in your reading.
    </p>

    <h2>Before a supervisor meeting</h2>
    <p>Spend ten minutes with your journal the day before and write one entry with three headings:</p>
    <ul>
        <li><strong>Since we last met:</strong> two or three lines of progress.</li>
        <li><strong>Decisions I'd like you to check:</strong> pulled straight from your "I decided" lines.</li>
        <li><strong>Where I'm stuck:</strong> pulled from your "I'm unsure about" lines.</li>
    </ul>
    <p>After the meeting, add what was agreed. Next time, you start from a written record instead of memory.</p>

    <h2>A reflexive journal for qualitative research</h2>
    <p>
        In qualitative research, a research journal often doubles as a <strong>reflexive journal</strong>: a record of
        how your own background, assumptions and reactions might shape what you notice and how you interpret it. After
        an interview or a coding session, add a line or two on questions like "What surprised me?" and "What did I
        expect to hear, and did that affect my questions?" Many methods chapters draw on exactly these notes when
        discussing reflexivity.
    </p>

    <h2>Keep sensitive data out of it</h2>
    <p>
        Your journal is about your thinking, not your raw data. Don't paste participant names, contact details,
        transcripts or anything your ethics approval says must stay in specific storage. Refer to participants by the
        codes you use in your project ("P07"), and keep the data itself where your institution requires.
    </p>

    <h2>Common mistakes</h2>
    <ul>
        <li>
            <strong>Only writing when something big happens.</strong> The small daily decisions are the ones you'll
            forget.
        </li>
        <li>
            <strong>Leaving out the reasons.</strong> "Dropped question 12" is useless later; "dropped question 12
            because three pilot participants misread it" is gold.
        </li>
        <li>
            <strong>Deleting dead ends.</strong> Failed approaches are part of the story and often belong in your
            limitations section.
        </li>
        <li>
            <strong>Writing for an audience.</strong> Nobody else needs to read it, so you can be honest about doubts.
        </li>
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
        you are: in the archive, the field, or on a train. Look for something private by default, organised by tags,
        that works offline and lets you export everything.
        <a href="{{ url('/for-students') }}">Ediary</a> does all of that for free, and our
        <a href="{{ url('/security') }}">security page</a> explains exactly how entries are protected.
    </p>
@endsection
