@extends('layouts.app')
@section('title', 'Security & Privacy at E-diary')
@push('meta')
    <link rel="canonical" href="{{ url('security') }}" />
    <meta
        name="description"
        content="How E-diary protects your journal: AES-256 encryption at rest, private by default, email-only signup, offline writing, and open-source code you can check yourself."
    />
    <meta
        name="keywords"
        content="E-diary security, encrypted diary, private journal, diary encryption, online diary privacy, open source diary"
    />
    <meta name="subject" content="How E-diary keeps your journal private" />
    <meta name="language" content="en" />
    <meta name="rating" content="General" />
@endpush
@section('content')
    <div class="bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-blue-600 py-20">
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute inset-0"
                    style="
                        background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0);
                        background-size: 40px 40px;
                    "
                ></div>
            </div>
            <div class="relative container mx-auto px-4 text-center">
                <h1 class="mb-6 text-4xl font-extrabold text-white md:text-6xl">Security & Privacy</h1>
                <p class="mx-auto max-w-2xl text-xl text-blue-100">
                    A plain-language explanation of how your journal is protected, including what we can and cannot do.
                </p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="container mx-auto max-w-4xl px-4 py-16">
            <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">The Short Version</h2>
                <div class="my-12 grid gap-8 md:grid-cols-2">
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Encrypted at Rest</h3>
                        <p>Every entry is encrypted with AES-256 before it is saved to our database.</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Private by Default</h3>
                        <p>New entries are private. Nobody else sees an entry unless you choose to share it.</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Minimal Data</h3>
                        <p>Just an email and a password to sign up. No ads, and we never sell your data.</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Open Source</h3>
                        <p>
                            Our code is public on
                            <a
                                href="https://github.com/itxshakil/ediary"
                                class="text-blue-600 hover:underline dark:text-blue-400"
                                rel="noopener"
                                >GitHub</a
                            >, so anyone can check how it works.
                        </p>
                    </div>
                </div>

                <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">How Encryption Works</h2>
                <p class="mb-6 leading-relaxed">
                    When you save an entry, its text is encrypted on our server with AES-256 and only the encrypted
                    version is written to the database. If someone got hold of a copy of the database or a backup, they
                    would see unreadable ciphertext instead of your words.
                </p>
                <p class="mb-6 leading-relaxed">
                    The encryption key is kept on our server, separately from the database. This is a deliberate choice:
                    if you forget your password, you can reset it and still have every entry. With apps where only you
                    hold the key, a forgotten password means your diary is gone forever.
                </p>
                <p class="mb-6 leading-relaxed">
                    It also means E-diary is not end-to-end encrypted. Our server decrypts an entry when you open it, so
                    in principle the service could read it. We don't, and we built the app so that nothing on our side
                    needs to look at your writing.
                </p>

                <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">What Is and Isn't Encrypted</h2>
                <ul class="mb-6 list-disc space-y-2 pl-6">
                    <li><strong>Encrypted:</strong> the text of every entry.</li>
                    <li>
                        <strong>Not encrypted:</strong> entry titles, moods, tags, and dates, so that search, filters,
                        and stats can work. Keep anything sensitive in the entry itself.
                    </li>
                    <li><strong>Not encrypted:</strong> your email address and username, which we need for login.</li>
                    <li><strong>Never stored in readable form:</strong> your password, which is hashed with bcrypt.</li>
                </ul>

                <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Who Can See Your Entries</h2>
                <p class="mb-6 leading-relaxed">
                    Every new entry starts as <strong>Private</strong>. You can change that on any single entry:
                </p>
                <ul class="mb-6 list-disc space-y-2 pl-6">
                    <li><strong>Private:</strong> only you.</li>
                    <li><strong>Followers:</strong> people who follow your profile.</li>
                    <li><strong>Unlisted:</strong> anyone with the link, but it is not listed anywhere.</li>
                    <li><strong>Public:</strong> anyone, and it can appear on Explore.</li>
                </ul>

                <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Writing Offline</h2>
                <p class="mb-6 leading-relaxed">
                    When you write without a connection, the entry is kept in your browser's storage on your own device
                    until you are back online. It is then sent to us over HTTPS and encrypted. If other people use your
                    device, sign out when you're done.
                </p>

                <h2 id="dictation" class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Dictation</h2>
                <p class="mb-6 leading-relaxed">
                    The Dictate button uses your browser's built-in speech recognition. Some browsers, including Chrome,
                    send your voice to their own speech service (Google, for Chrome) to turn it into text, so dictation
                    needs an internet connection. E-diary never receives or stores audio: only the text that appears in
                    your entry is saved, and it is encrypted like everything else you type. If you'd rather keep your
                    voice off third-party services, simply type instead.
                </p>

                <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Your Data, Your Control</h2>
                <p class="mb-6 leading-relaxed">
                    You can export all of your entries at any time, or
                    <a href="{{ url('/request-data') }}" class="text-blue-600 hover:underline dark:text-blue-400"
                        >request a copy of your data</a>
                    by email. If you find a security issue, please
                    <a href="{{ url('/contact') }}" class="text-blue-600 hover:underline dark:text-blue-400"
                        >contact us</a>
                    and we will respond quickly.
                </p>
            </div>

            @include('blogs._cta')
        </div>
    </div>
@endsection
