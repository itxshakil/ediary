<?php

declare(strict_types=1);

/*
 * Feature landing pages for searches the app answers directly ("mood journal online", "voice
 * journal", "secret diary online"). Rendered by resources/views/pages/landing.blade.php.
 *
 * Every claim here must be true of the app today; when a feature changes, update its page.
 * - headline: <title> (fits 60 chars with " | Ediary"); meta_description: under 155 chars
 * - uses: three cards; features: the "why" list; steps: three; faqs: shown on the page
 */
return [
    'pages' => [
        'mood-journal' => [
            'headline' => 'Mood Journal Online: Free Mood Tracker Diary',
            'meta_description' => 'A free online mood journal: tag each entry with how you feel, see your week at a glance and spot patterns over time. Private by default.',
            'eyebrow' => 'Mood journal',
            'title' => 'A mood journal that shows you the patterns',
            'subtitle' => 'Write a few lines, tap how you feel, and watch your moods over days and months. Free, private by default, and it works offline.',
            'cta' => 'Start your mood journal',
            'uses' => [
                ['title' => 'Log how you feel', 'body' => 'Pick one of nine moods for any entry, from happy and calm to anxious, tired or angry. It takes a second and adds context words alone miss.'],
                ['title' => 'See your week', 'body' => 'Your journal shows the last seven days of moods at a glance, so a run of tired or anxious days is easy to notice.'],
                ['title' => 'Spot the patterns', 'body' => 'Stats show how your moods are distributed, when in the day you write and which tags come up most, so you can connect how you feel with what you do.'],
            ],
            'features' => [
                ['title' => 'Words and moods together.', 'body' => 'A mood tracker tells you that you felt low. A journal entry next to it tells you why.'],
                ['title' => 'Filter by mood.', 'body' => 'Open every entry tagged with one mood to see what those days had in common.'],
                ['title' => 'Private by default.', 'body' => 'Entries are encrypted at rest and only visible to you unless you choose to share one.'],
                ['title' => 'Works offline.', 'body' => 'Write without a connection; entries sync when you are back online.'],
                ['title' => 'Prompts when you are stuck.', 'body' => 'A daily writing prompt helps on the days you do not know where to start.'],
                ['title' => 'Free and unlimited.', 'body' => 'No entry limits, no ads, and just an email to sign up.'],
            ],
            'steps' => [
                'Sign up with your email address.',
                'Write a sentence about your day and tap the mood that fits.',
                'Come back tomorrow: after a week, your mood chart starts to tell a story.',
            ],
            'faqs' => [
                ['q' => 'Which moods can I track?', 'a' => 'Happy, sad, calm, angry, anxious, thoughtful, tired, excited and neutral. Choosing a mood is optional on every entry.'],
                ['q' => 'Is a mood journal the same as therapy?', 'a' => 'No. A mood journal can help you notice patterns and put feelings into words, but it is not a replacement for professional support. If you are struggling, please talk to someone you trust or a health professional.'],
                ['q' => 'Who can see my moods?', 'a' => 'Only you, unless you share an entry. Moods and tags are stored unencrypted so filters and stats work, while the entry text itself is encrypted. See the security page for details.'],
            ],
            'related' => ['prompts' => 'evening-reflection', 'post' => 'how-to-start-writing-a-diary'],
        ],
        'voice-journal' => [
            'headline' => 'Voice Journal: Dictate Your Diary in the Browser',
            'meta_description' => 'Speak your diary entries instead of typing: Ediary turns your voice into text in the browser. Free, private by default, no app to install.',
            'eyebrow' => 'Voice journal',
            'title' => 'Talk to your diary instead of typing',
            'subtitle' => 'Press Dictate, speak, and your words appear in the entry. Edit, add a mood, save. Free, in your browser, no app store.',
            'cta' => 'Try voice journaling',
            'uses' => [
                ['title' => 'End-of-day recaps', 'body' => 'Too tired to type? Talk through your day in a minute and tidy it up later, or not at all.'],
                ['title' => 'Thoughts on the move', 'body' => 'Capture an idea while walking or cooking, then come back to it when you have time.'],
                ['title' => 'Writing without the keyboard', 'body' => 'If typing slows you down or gets in the way of your thoughts, speaking keeps them flowing.'],
            ],
            'features' => [
                ['title' => 'Mix voice and typing.', 'body' => 'Dictation adds text where your cursor is, so you can speak a paragraph, type a correction and carry on.'],
                ['title' => 'Only text is saved.', 'body' => 'Ediary never receives or stores audio. The text is encrypted at rest like everything you type.'],
                ['title' => 'Nothing to install.', 'body' => 'It works in the browser on your phone or computer, and you can add Ediary to your home screen.'],
                ['title' => 'Moods, tags and prompts.', 'body' => 'Voice entries are normal entries: add a mood, tag them, and find them again later.'],
                ['title' => 'Private by default.', 'body' => 'Nobody else sees an entry unless you choose to share it.'],
                ['title' => 'Free and unlimited.', 'body' => 'No entry limits, no ads, and just an email to sign up.'],
            ],
            'steps' => [
                'Sign up with your email address.',
                'Open a new entry and press Dictate.',
                'Speak, then press it again to stop. Fix anything you like and save.',
            ],
            'faqs' => [
                ['q' => 'Which browsers support dictation?', 'a' => "Dictation uses the browser's built-in speech recognition, available in Chrome, Edge and Safari. Firefox does not support it yet; the Dictate button only appears where it works."],
                ['q' => 'Is my voice sent anywhere?', 'a' => 'Your browser turns speech into text. Some browsers, including Chrome, send the audio to their own speech service (Google, for Chrome) to do that, so dictation needs a connection. Ediary itself only ever receives the text. If you would rather not use a speech service, just type.'],
                ['q' => 'Does it understand my language?', 'a' => "It uses your browser's speech recognition, which supports many languages. Accuracy depends on the browser and your microphone."],
            ],
            'related' => ['prompts' => 'evening-reflection', 'post' => 'how-to-choose-a-private-journal-app'],
        ],
        'private-diary' => [
            'headline' => 'Secret Diary Online: Private and Password-Protected',
            'meta_description' => 'A free secret diary online: password-protected, private by default and encrypted at rest. No app to install, just an email to sign up.',
            'eyebrow' => 'Private diary',
            'title' => 'A secret diary only you can open',
            'subtitle' => 'Password-protected, private by default and encrypted at rest. Write on your phone or computer, even offline. Free, with just an email.',
            'cta' => 'Create your private diary',
            'uses' => [
                ['title' => 'Thoughts you keep to yourself', 'body' => 'Write the things you would not say out loud. Every entry starts private and stays that way unless you change it.'],
                ['title' => 'A diary that travels with you', 'body' => 'Sign in from any device with your password. No paper diary to hide, lose or have someone find.'],
                ['title' => 'Sharing, only when you choose', 'body' => 'Want to share one entry? Make just that one visible to followers, by link or publicly. The rest stay private.'],
            ],
            'features' => [
                ['title' => 'Password-protected.', 'body' => 'Your diary sits behind your account password, which is never stored in readable form.'],
                ['title' => 'Encrypted at rest.', 'body' => 'Entry text is encrypted with AES-256 before it reaches the database, so a copy of the database shows unreadable text.'],
                ['title' => 'Honest about limits.', 'body' => 'Ediary is not end-to-end encrypted: the server decrypts an entry when you open it, which is also why a forgotten password never costs you your diary.'],
                ['title' => 'Minimal data.', 'body' => 'Just an email and a password. No real name, no phone number, no ads, and we never sell data.'],
                ['title' => 'Works offline.', 'body' => 'Write without a connection; entries sync when you reconnect.'],
                ['title' => 'Yours to keep.', 'body' => 'Export every entry at any time, and the code is open source on GitHub.'],
            ],
            'steps' => [
                'Sign up with your email and a password.',
                'Write your first entry. It is private by default.',
                'Sign out on shared devices, and add Ediary to your home screen on your own.',
            ],
            'faqs' => [
                ['q' => 'Can anyone else read my diary?', 'a' => 'Other people cannot see an entry unless you share it. Because Ediary is not end-to-end encrypted, the service could technically decrypt entries; we do not, and nothing on our side needs to read your writing.'],
                ['q' => 'What if I forget my password?', 'a' => 'Reset it by email and every entry is still there. That is the trade-off of not using end-to-end encryption, where a forgotten password means a lost diary.'],
                ['q' => 'Is it really free?', 'a' => 'Yes. Unlimited entries, no ads and no paid plan.'],
            ],
            'related' => ['prompts' => 'self-reflection', 'post' => 'how-to-choose-a-private-journal-app'],
        ],
    ],
];
