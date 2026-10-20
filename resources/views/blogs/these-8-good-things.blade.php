@extends('layouts.blog-post')

@section('article')
    <p class="text-xl leading-relaxed font-medium text-gray-600 italic md:text-2xl dark:text-gray-400">
        Journaling won't fix your life. But a few honest minutes a day changes more than you'd expect, and most of the
        changes show up within weeks.
    </p>

    <p>
        People start keeping a diary for all sorts of reasons: a stressful year, a new job, a wish to remember more.
        Whatever brings you to it, these are the things that tend to happen once writing becomes a habit.
    </p>

    <h2>1. Your head gets quieter</h2>
    <p>
        Thoughts that loop in your head often lose their grip once they're on a page. Writing a worry down turns a vague
        feeling into a specific sentence, and specific sentences are easier to deal with, or to put down for the night.
        Many people find an evening entry helps them fall asleep with less on their mind.
    </p>

    <h2>2. You understand your feelings better</h2>
    <p>
        "I feel bad" is hard to act on. "I feel left out because nobody asked me to lunch" is something you can
        understand and maybe change. Journaling makes you name feelings precisely. Psychologists have long studied
        expressive writing, starting with James Pennebaker's experiments in the 1980s, and putting emotions into words
        is consistently linked with feeling less overwhelmed by them.
    </p>

    <h2>3. You remember more of your own life</h2>
    <p>
        Memory is generous with big events and stingy with ordinary days. A diary keeps the small things: what a friend
        said that made you laugh, the meal you cooked when you were homesick, what you were worried about before it all
        worked out. A year from now, those details are what you'll be glad you wrote down.
    </p>

    <h2>4. You start to see patterns</h2>
    <p>
        One entry tells you about a day. Thirty entries tell you about yourself. Read back a month and you'll notice
        that Sunday evenings always feel heavy, that a certain friend always leaves you energised, or that you sleep
        worse when you skip exercise. Tracking your <a href="{{ url('mood-journal') }}">mood next to your entries</a>
        makes these patterns even easier to spot.
    </p>

    <h2>5. Decisions get easier</h2>
    <p>
        When you're stuck, writing both sides of a decision slows your thinking down enough to notice what you actually
        want. You'll often find the answer was already there, hidden under the noise. Later, your diary also shows you
        how past decisions played out, which is useful the next time you face something similar.
    </p>

    <h2>6. You get kinder to yourself</h2>
    <p>
        Reading back old entries, you see how much you were dealing with and how you got through it. That makes it
        harder to be harsh with yourself today. Many people notice their entries slowly shift from criticism ("I should
        have...") to curiosity ("Why did I...?").
    </p>

    <h2>7. Your thinking gets clearer</h2>
    <p>
        Writing regularly is practice at turning messy thoughts into clear sentences. Over time that carries over into
        emails, essays, conversations and arguments. You don't need to write well in your diary for this to happen; you
        just need to write often.
    </p>

    <h2>8. You can see how far you've come</h2>
    <p>
        Progress is invisible from the inside. The problem that felt enormous in January looks smaller in June, but only
        if you can read what January felt like. A diary is the most honest record of growth you'll ever have, and on bad
        days it's a reminder that you've handled hard things before.
    </p>

    <h2>How to get these benefits</h2>
    <p>None of this needs long entries. What matters is regularity:</p>
    <ul>
        <li><strong>Write a little, often.</strong> Three sentences most days beats a page once a month.</li>
        <li><strong>Be honest.</strong> Keep your diary private, so you can write what you actually think.</li>
        <li><strong>Read it back.</strong> Once a month, look over recent entries; that's when patterns appear.</li>
        <li>
            <strong>Use prompts when stuck.</strong> Our <a href="{{ url('journal-prompts') }}">journal prompts</a>
            give you a question to start from.
        </li>
    </ul>
    <p>
        New to journaling? Read
        <a href="{{ url('blogs/how-to-start-writing-a-diary') }}">how to start writing a diary</a> for a simple way to
        make the habit stick.
    </p>

    <p class="text-sm text-gray-500 dark:text-gray-400">
        Journaling can support your wellbeing, but it isn't a substitute for professional help. If you're struggling,
        please reach out to someone you trust or a health professional.
    </p>
@endsection
