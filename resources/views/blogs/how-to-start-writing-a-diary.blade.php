@extends('layouts.blog-post')

@section('article')
    <p class="text-xl leading-relaxed font-medium text-gray-600 italic md:text-2xl dark:text-gray-400">
        Most diaries don't fail on day one. They fail on day nine, when life gets busy and the habit was never small
        enough to survive a busy day.
    </p>

    <p>
        Starting a diary is easy: you write something. Keeping one is the hard part. This guide is about both, with the
        emphasis on the second, because a diary you keep for a year is worth far more than a beautiful first week.
    </p>

    <h2>You need less than you think</h2>
    <p>
        You don't need a special notebook, a theme or a writing style. You need a place to write and a few minutes. A
        paper notebook feels personal and keeps you off screens. An app is always in your pocket, can't be found in a
        drawer, and makes old entries easy to search and read back. Pick whichever you will actually open on a tired
        evening. You can always switch later.
    </p>

    <h2>Make it too small to skip</h2>
    <p>
        The most common mistake is aiming too high: an hour a day, a page every night. That works until the first bad
        week. Instead, set a minimum so low it feels silly, such as <strong>two minutes or three sentences</strong>. On
        good days you will write more anyway. On bad days the minimum keeps the habit alive, and a habit that survives
        bad days is a habit that lasts.
    </p>

    <h2>Attach it to something you already do</h2>
    <p>
        "I'll write when I have time" rarely happens. "I'll write after I brush my teeth" usually does. Tie your diary
        to an existing moment:
    </p>
    <ul>
        <li>with your first coffee or tea in the morning,</li>
        <li>on the commute home, if you don't drive,</li>
        <li>straight after dinner, before the evening disappears,</li>
        <li>in bed, before you put your phone away.</li>
    </ul>
    <p>
        Morning entries tend to be about intentions; evening entries tend to be about what happened. Neither is better.
        Choose the one that fits your day and stick to it for two weeks before judging.
    </p>

    <h2>Your first entry</h2>
    <p>Don't try to write your life story. Write about today, plus one line about why you are starting. For example:</p>
    <blockquote>
        Starting a diary because the year is flying past and I can't remember what happened in March. Today: rain, long
        meeting, good soup. Called Mum, she sounded tired. Want to check in on her again this weekend.
    </blockquote>
    <p>That is a complete, useful entry. It took a minute.</p>

    <h2>What to write when "nothing happened"</h2>
    <p>Something always happened; it just doesn't feel worth writing. Try one of these:</p>
    <ul>
        <li><strong>One moment.</strong> The best or worst five minutes of the day, in detail.</li>
        <li><strong>One feeling.</strong> Name it, then ask where it came from.</li>
        <li><strong>One person.</strong> Someone you talked to, thought about or miss.</li>
        <li><strong>One thing on your mind.</strong> A worry, an idea, a decision you're circling.</li>
        <li><strong>One thing you noticed.</strong> Something you saw, heard, read or tasted.</li>
    </ul>
    <p>
        If you want ready-made questions, browse our <a href="{{ url('journal-prompts') }}">journal prompts</a>; the
        <a href="{{ url('journal-prompts/evening-reflection') }}">evening reflection prompts</a> are a good place to
        start.
    </p>

    <h2>Write as if nobody will read it</h2>
    <p>
        A diary is the one place you don't have to perform. Messy sentences, half-thoughts and unfair opinions are all
        fine. You will write more honestly if you trust that nobody else will read it, so keep your diary somewhere
        private. If you use an app, check how it protects your entries; here is
        <a href="{{ url('security') }}">how Ediary handles privacy</a>.
    </p>

    <h2>When you miss days (you will)</h2>
    <p>
        Missing a day isn't failing. Missing a day and deciding the diary is over is. When you come back, don't try to
        catch up on everything you missed. Write today's entry, maybe add one line like "busy week, more soon", and
        carry on. The diary only needs to be continuous enough to be useful, not perfect.
    </p>

    <h2>Read it back</h2>
    <p>
        The real reward of a diary arrives weeks later. Once a month, read your last few weeks of entries. You'll notice
        patterns you couldn't see day to day: which weeks drained you, which people lifted you, what kept coming up.
        That moment of recognition is what keeps most people writing.
    </p>

    <h2>Quick answers</h2>
    <p>
        <strong>How long should an entry be?</strong> As long as it takes to say what's on your mind. Three sentences is
        a fine daily minimum.
    </p>
    <p>
        <strong>Should I write every day?</strong> Aim for most days. Daily is easiest to keep because it never becomes
        a decision.
    </p>
    <p>
        <strong>Typing or handwriting?</strong> Whichever you'll keep doing. If typing feels slow on a phone, try
        <a href="{{ url('voice-journal') }}">dictating your entry</a> instead.
    </p>
    <p>
        <strong>What if I don't like what I wrote?</strong> Leave it. Your diary is a record, not a portfolio, and
        rereading the awkward entries is often the most interesting part.
    </p>
@endsection
