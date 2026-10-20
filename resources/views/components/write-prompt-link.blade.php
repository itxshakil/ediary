{{-- Opens a new entry with the prompt as its title; guests sign up first and land on the same form. --}}
@props(['prompt'])

@php
    $create = route('diary.create', ['prompt' => $prompt], absolute: false);
    $href = auth()->check() ? url($create) : route('register', ['next' => $create]);
@endphp

<a
    href="{{ $href }}"
    data-track="prompt_write_clicked"
    rel="nofollow"
    {{ $attributes->class(['text-primary-600 dark:text-primary-400 shrink-0 text-sm font-semibold whitespace-nowrap hover:underline']) }}
>
    Write about this<span class="sr-only">: {{ $prompt }}</span> &rarr;
</a>
