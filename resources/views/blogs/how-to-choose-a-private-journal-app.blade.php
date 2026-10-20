@extends('layouts.blog-post')

@section('article')
    <p class="text-xl leading-relaxed font-medium text-gray-600 italic md:text-2xl dark:text-gray-400">
        Almost every journal app calls itself private. The useful question is: private from whom, and how?
    </p>

    <p>
        A journal holds the things you wouldn't say out loud, so it's worth five minutes to check what an app actually
        does with your words. These seven questions cover what matters. We've answered each one for Ediary too,
        honestly, including where other apps make a different trade-off.
    </p>

    <h2>1. Where is the encryption key kept?</h2>
    <p>"Encrypted" can mean very different things. There are two common models:</p>
    <ul>
        <li>
            <strong>End-to-end (zero-knowledge) encryption:</strong> only your device holds the key. The company can't
            read your entries, but if you forget your password, your journal is usually gone for good.
        </li>
        <li>
            <strong>Encryption at rest:</strong> entries are encrypted in the database and the key is kept separately on
            the server. A leaked database or backup is unreadable, and you can reset a forgotten password without losing
            anything. The trade-off is that the service could, in principle, decrypt your entries.
        </li>
    </ul>
    <p>
        Neither is wrong. Pick the one that matches your biggest fear: someone reading your journal, or losing it.
        <strong>Ediary uses encryption at rest</strong> (AES-256), because we think losing years of writing to a
        forgotten password is the more common disaster. Our
        <a href="{{ url('/security') }}">security page</a>
        explains the details.
    </p>

    <h2>2. What exactly is encrypted?</h2>
    <p>
        Often only the entry text is encrypted, while titles, tags, and dates are stored as plain text so search and
        filters work. That's a reasonable design, but you should know about it so you can keep sensitive details out of
        titles. In Ediary, entry text is encrypted, and titles, moods, tags, and dates are not.
    </p>

    <h2>3. How much personal data do I have to give?</h2>
    <p>
        A journal doesn't need your name, birthday, phone number, or contacts. The less you hand over, the less there is
        to leak. Ediary asks for an email address and a password, and nothing else.
    </p>

    <h2>4. How does the company make money?</h2>
    <p>
        If an app is free and shows ads, your attention or data is part of the product. Look for a clear statement that
        your data is never sold or used for advertising. Ediary has no ads and never sells data.
    </p>

    <h2>5. Is everything private by default?</h2>
    <p>
        Some journal apps include social features. That's fine if sharing is opt-in for each entry. Check that a new
        entry starts private and that nothing is shared unless you choose it. In Ediary every entry starts private, and
        you can choose to share individual entries with followers, by link, or publicly.
    </p>

    <h2>6. Does it work offline?</h2>
    <p>
        If you write on trains, planes, or anywhere with patchy signal, offline support matters. Check whether offline
        entries sync automatically once you're back online. Ediary works offline in the browser and syncs when you
        reconnect.
    </p>

    <h2>7. Can I take my journal with me?</h2>
    <p>
        You should be able to export everything in a standard format at any time. If you can't leave, you don't really
        own your journal. Ediary lets you export all of your entries whenever you like.
    </p>

    <h2>Bonus: can you check the claims?</h2>
    <p>
        Open-source apps let anyone inspect how data is handled, which is a strong sign that the privacy claims are
        real. Ediary's code is
        <a href="https://github.com/itxshakil/ediary" rel="noopener">public on GitHub</a>.
    </p>

    <h2>The short version</h2>
    <ul>
        <li>Decide whether you fear someone reading it or you losing it, and choose the encryption model to match.</li>
        <li>Know which parts are encrypted.</li>
        <li>Give as little personal data as possible.</li>
        <li>Avoid ad-funded journals.</li>
        <li>Make sure entries are private by default, it works offline, and you can export everything.</li>
    </ul>
@endsection
