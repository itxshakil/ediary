@extends('layouts.app')
@section('title')
These 8 Good Things Will Happen When You Start Writing Diaries
@endsection
@section('content')
<div class="container mx-auto px-3 md:px-6">
    <article class="bg-gray-200 rounded-lg p-4 m-2">
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-center pb-4">
            These 8 Good Things Will Happen When You Start Writing Diaries
        </h1>
        <p class="text-xl mb-1">
            Writing to yourself is an important means of self-expression. Whether you call it a diary or refer to it as
            a journal, having a place to write down your thoughts, feelings, memories and personal impressions about
            life can be healing and teach you to know yourself better. It can also unlock the power of your creativity,
            and inspire you to manifest dreams that might otherwise stay hidden. If you don't keep a diary already, here
            are 8 good things that will happen when you start writing diaries.

        </p>
        <h2 class="text-3xl py-2  font-semibold">
            1. You'll Know Yourself better

        </h2>
        <p class="text-xl mb-1">
            History tells us that the Greek philosopher Socrates, often credited as the source for the famous adage Know
            Thyself, used a method of teaching which involved dialogues, questions and answers between individuals going
            back and forth that whittled an issue down to its deepest level of truth. When writing a diary, it is very
            common for us to engage in similar forms of inquiry on paper, writing out questions about life and then
            answering them ourselves.

        </p>
        <p class="text-xl mb-1">
            Whether you come to a final truth in the end is less important than the actual process of giving voice to
            your own inner reasoning and various points of view. This process of allowing more than one point of view to
            emerge encourages you to witness your own self, even when it may be fragmented, unsure, or expressing
            emotions that contradict each other. It allows you to see and acknowledge your true complexity. Witnessing
            the richness of your human experience and being able to see it on paper truly helps you to, as the great
            philosopher said, know thyself.

        </p>
        <h2 class="text-3xl py-2  font-semibold">
            2. You'll Express Yourself

        </h2>
        <p class="text-xl mb-1">
            Expressing yourself is another important aspect of keeping a diary. Beyond simply offering a means of
            self-expression through the written word, often diaries are full of doodles and drawings that accentuate the
            actual text of what is being written. These doodles can be as simple as the butterflies drawn by a child who
            is joyful, or the tornadoes on the edge of the paper created by a teenager who is disturbed.

        </p>
        <p class="text-xl mb-1">
            Regardless of the actual content, this mirror of expression allows you to say what otherwise might be too
            challenging to say and give voice to emotions that may otherwise be repressed. It allows you to rehearse
            difficult conversations on paper as well. Having the blank page to fill up is in many ways an analogy to
            life, seeing yourself be expressed one letter and one doodle at a time.

        </p>
        <h2 class="text-3xl py-2  font-semibold">
            3. You'll Work Through Hard Choices
        </h2>
        <p class="text-xl mb-1">
            When life sends you any kind of challenge, you can work through those options in your diary, noting the
            moral implications as well as the emotional pains of decisions that are difficult to make. As an extreme
            example, here is a link to a famous diary entry of a Patrick Breen, a member of the ill-fated Donner party
            group of pioneers who were trapped in the Sierra Nevada mountains in the winter of 1846-1847, some of whom
            resorted to cannibalism
        </p>
        <a href="http://blog.paperblanks.com/2013/05/famous-diary-entries-donner-party/">here is the link</a>
        <h2 class="text-3xl py-2  font-semibold">
            4. You'll Develop Emotional Intimacy
        </h2>
        <p class="text-xl mb-1">
            Keeping a diary is a process not only of self-expression but also self-reflection. As you read what you have
            written, whether it is a recent entry or one from many months or years ago, it becomes a means of listening
            to yourself and uncovering the emotional landscape of who you truly are. By developing this sense of
            intimacy with yourself, it opens the possibility for greater emotional intimacy with others.

        </p>
        <h2 class="text-3xl py-2  font-semibold">
            5. You'll Feel Better as You Put Your Thoughts and Feelings on Paper

        </h2>
        <p class="text-xl mb-1">
            Often, a diary is that safe place where we can unleash thoughts or emotions that might be too uncomfortable
            to express in a more public setting. Whether it is venting anger, writing about a romantic crush, or being
            the important place to grieve the loss of a loved one, having a safe place to release your thoughts and
            emotions usually makes you feel better as a whole by providing an outlet for thoughts and feelings that
            otherwise could otherwise get bottled up inside of you.

        </p>
        <h2 class="text-3xl py-2  font-semibold">
            6. You'll Build Memories on Paper
        </h2>
        <p class="text-xl mb-1">
            Sometimes even the smallest details of events in our past are items we grow to cherish as we get older. By
            keeping a detailed diary you are documenting those moments in your life that is worth writing about.

        </p>
        <h2 class="text-3xl py-2  font-semibold">
            7. You'll Brainstorm New Ideas

        </h2>
        <p class="text-xl mb-1">
            Having the opportunity to brainstorm and toss out ideas without being attached to an outcome is a diary tool
            used by some of the worlds greatest artistic geniuses. Here is an example of how film director Stanley
            Kubrick used this technique to arrive at the title of one of his most famous films.

        </p>
        <h2 class="text-3xl py-2  font-semibold">
            8. You'll Create a Map That Holds Secrets to Your Own Evolution
        </h2>
        <p class="text-xl mb-1">
            A diary reveals far more about a person than simply the details of what is written inside of it. You don't
            have to hold a college degree in the science of Graphology (handwriting analysis) to see how your own
            handwriting reveals secrets about your psychological state of being. Noticing how your handwriting changes
            as you grow older, when it is bold and confident versus when it small and timid, is just one of the
            interesting benefits of keeping a diary over a long period of time.
        </p>
        <p class="text-xl mb-1">
            These 8 reasons to start a diary will hopefully get you started.

        </p>
    </article>
    <div class="rounded-lg bg-gray-400 p-4 text-center">
        @auth
        <a class="bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-lg outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            href="/home">Start writing Now</a>
        @else
        <a class="bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-lg outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            href="/login">Start Writing now</a>
        @endauth
    </div>
    <h3 class="text-xl underline p-4 font-bold">Related Articles</h3>
    <div class="flex flex-col md:flex-row gap-4 p-4">
        <div class="w-full h-auto bg-gray-400 lg:block lg:w-1/2 bg-cover rounded-lg p-4 m-1">
            <h2 class="font-bold text-lg"><a href="/blogs/how-to-write-diary">How to write a Diary</a></h2>
            <p>Diaries are wonderful objects that allow you to discuss your emotions, record dreams or ideas, and
                reflect
                on
                daily life in a safe, private space. While there's no single, definitive way to write a diary, there are
                some
                basic tricks you can use to get the most out of your writing. If you aren't sure what to write about,
                using
                prompts like inspirational quotes can help get started on new entries. <a
                    href="/blogs/how-to-write-diary" class="text-blue-600">read more...</a></p>
        </div>
        <div class="w-full h-auto bg-gray-400 lg:block lg:w-1/2 bg-cover rounded-lg p-4 m-1">
            <h2 class="font-bold text-lg"><a href="/blogs/how-to-start-writing-a-diary">How to Start Writing a Diary</a>
            </h2>
            <p>To start a diary, all you need is a willingness to write. Start by figuring out what you want
                to write in your journal.
                If you aren’t sure, simply start writing and see where that leads. It can also be useful to set a time
                limit
                in your
                early writing sessions. Set an alarm for 10 to 20 minutes and start writing.<a
                    href="/blogs/how-to-start-writing-a-diary" class="text-blue-600">read
                    more...</a></p>
        </div>
    </div>
</div>
@endsection