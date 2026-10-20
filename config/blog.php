<?php

declare(strict_types=1);

/*
 * Blog post registry, newest first. Routes, the blog index (cards and JSON-LD), related-post links
 * and the sitemap all read from here, so adding a post means one entry plus its view.
 *
 * - view: blade view under resources/views/blogs, also the route name suffix (blogs.{view})
 * - title: short title for cards and the article heading; headline: full page title (defaults to title)
 * - description: card and structured-data summary; meta_description: search snippet (defaults to description)
 * - date: first published; updated: last meaningful revision (sitemap lastmod and dateModified, defaults to date)
 * - listed: false keeps a post out of the index, its structured data and the sitemap while it stays reachable
 */
return [
    'posts' => [
        'how-to-keep-a-study-journal' => [
            'view' => 'how-to-keep-a-study-journal',
            'title' => 'How to Keep a Study Journal',
            'headline' => 'How to Keep a Study Journal (With a Simple Template)',
            'description' => 'What to write after each study session, a five-minute template, and how your journal makes revision easier.',
            'meta_description' => 'A study journal helps you remember more and revise faster. Learn what to write after each session, a five-minute template, and how to use it at revision time.',
            'keywords' => ['study journal', 'journal for students', 'study log', 'study journal template', 'reflective journal for students', 'revision tips'],
            'badge' => 'Students',
            'author' => 'Shakil Alam',
            'date' => '2026-10-18',
            'minutes' => 6,
            'related' => ['journaling-prompts-for-students', 'how-to-keep-a-research-journal'],
        ],
        'how-to-keep-a-research-journal' => [
            'view' => 'how-to-keep-a-research-journal',
            'title' => 'How to Keep a Research Journal',
            'headline' => "How to Keep a Research Journal During Your PhD or Master's",
            'description' => 'What to write, how often, and how a research journal pays off in your methods chapter and supervisor meetings.',
            'meta_description' => 'A research journal records your decisions, dead ends, and ideas as they happen. Learn what to write, how often, and how it helps with your thesis and supervisor meetings.',
            'keywords' => ['research journal', 'PhD journal', 'reflective research diary', 'research diary template', 'thesis writing', 'PhD reflective journal'],
            'badge' => 'Researchers',
            'author' => 'Shakil Alam',
            'date' => '2026-10-18',
            'minutes' => 7,
            'related' => ['how-to-keep-a-study-journal', 'how-to-choose-a-private-journal-app'],
        ],
        'journaling-prompts-for-students' => [
            'view' => 'journaling-prompts-for-students',
            'title' => '40 Journaling Prompts for Students',
            'description' => 'Prompts for study reflection, exam stress, motivation, friendships, and the end of the semester.',
            'meta_description' => '40 journaling prompts for students: study reflection, exam stress, motivation, friendships, and end-of-semester review. Pick one and write for five minutes.',
            'keywords' => ['journaling prompts for students', 'journal prompts for college students', 'exam stress journal prompts', 'study reflection prompts', 'end of semester reflection'],
            'badge' => 'Prompts',
            'author' => 'Shakil Alam',
            'date' => '2026-10-18',
            'minutes' => 5,
            'related' => ['how-to-keep-a-study-journal', 'these-8-good-things-will-happen-when-you-start-writing-diary'],
        ],
        'how-to-choose-a-private-journal-app' => [
            'view' => 'how-to-choose-a-private-journal-app',
            'title' => 'How to Choose a Private Journal App',
            'headline' => 'How to Choose a Private Journal App: 7 Questions to Ask',
            'description' => 'Encryption, data collection, offline access, sharing, and export: what to check before you trust an app with your journal.',
            'meta_description' => "Not every 'private' journal app means the same thing. Seven questions about encryption, data collection, offline access, sharing, and export to ask before you start writing.",
            'keywords' => ['private journal app', 'private online diary', 'encrypted diary', 'offline diary app', 'secure journal', 'end-to-end encrypted journal'],
            'badge' => 'Privacy',
            'author' => 'Shakil Alam',
            'date' => '2026-10-18',
            'minutes' => 7,
            'related' => ['how-to-keep-a-research-journal', 'how-to-start-writing-a-diary'],
        ],
        'goal-setting-for-success' => [
            'view' => 'goal-setting-for-success',
            'title' => '5 Steps to Design the Life You’ve Always Dreamed Of',
            'description' => 'Ready to turn your goals into achievements? Learn the best strategies for setting clear, actionable goals that lead to real success.',
            'keywords' => ['Goal Setting', 'Personal Growth', 'Journaling'],
            'badge' => 'Goal Setting',
            'author' => 'Shakil Alam',
            'date' => '2024-12-21',
            'related' => ['how-to-start-writing-a-diary', 'these-8-good-things-will-happen-when-you-start-writing-diary'],
        ],
        'these-8-good-things-will-happen-when-you-start-writing-diary' => [
            'view' => 'these-8-good-things',
            'title' => '8 Good Things That Happen When You Start Journaling',
            'description' => 'Writing to yourself is an important means of self-expression. Discover how a diary can be healing, unlock creativity, and help you know yourself better.',
            'keywords' => ['Diary Benefits', 'Creativity', 'Self-Expression'],
            'badge' => 'Benefits',
            'badge_color' => 'purple',
            'author' => 'Internet Blogger',
            'date' => '2024-12-21',
            'related' => ['how-to-write-diary', 'how-to-start-writing-a-diary'],
        ],
        'how-to-start-writing-a-diary' => [
            'view' => 'how-to-start-writing-a-diary',
            'title' => 'How to Start Writing a Diary',
            'description' => 'To start a diary, all you need is a willingness to write. Learn how to figure out what you want to write and how to make it a daily habit.',
            'keywords' => ['Starting a Diary', 'Journaling Tips', 'Writing Habit'],
            'badge' => 'Getting Started',
            'badge_color' => 'green',
            'author' => 'Shakil Alam',
            'date' => '2024-12-21',
            'related' => ['how-to-write-diary', 'these-8-good-things-will-happen-when-you-start-writing-diary'],
        ],
        'how-to-write-diary' => [
            'view' => 'how-to-write',
            'title' => 'How to Write a Diary',
            'description' => 'Learn tips and tricks to get the most out of writing a diary. Explore ways to discuss emotions, record ideas, and reflect on life.',
            'keywords' => ['Diary Writing', 'Journaling Tips', 'Self-Expression'],
            'badge' => 'Journaling Tips',
            'author' => 'WikiHow',
            'date' => '2024-12-21',
            'listed' => false,
            'related' => ['these-8-good-things-will-happen-when-you-start-writing-diary', 'how-to-start-writing-a-diary'],
        ],
    ],
];
