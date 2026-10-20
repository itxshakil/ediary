{{-- "Need an idea?" for an entry form. Behaviour lives in resources/js/modules/writing-prompt.js. --}}
@props(['title' => 'title', 'entry' => 'entry'])

@php
    $prompts = config('prompts.daily');
    $today = now(auth()->user()?->localTimezone() ?? config('app.user_timezone'));
    $index = $today->dayOfYear % count($prompts);
@endphp

<div
    {{ $attributes->class(['flex flex-wrap items-center gap-x-3 gap-y-2 rounded-xl bg-primary-50/70 px-4 py-3 text-sm dark:bg-primary-900/20']) }}
    data-writing-prompt
    data-prompts='@json($prompts)'
    data-index="{{ $index }}"
    data-title-field="{{ $title }}"
    data-entry-field="{{ $entry }}"
>
    <span class="text-primary-700 dark:text-primary-300 font-semibold">Need an idea?</span>
    <span class="min-w-0 flex-1 text-gray-700 dark:text-gray-200" data-prompt-text>{{ $prompts[$index] }}</span>
    <span class="flex shrink-0 items-center gap-2">
        <x-button size="sm" variant="secondary" type="button" data-prompt-use>Use this prompt</x-button>
        <x-button size="sm" variant="ghost" type="button" data-prompt-next aria-label="Show another prompt"
            >Another</x-button>
    </span>
</div>
