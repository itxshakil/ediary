@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'loading' => false,
    'disabled' => false,
])

@php
    $classes = [
        'relative inline-flex shrink-0 items-center justify-center gap-2 rounded-full font-medium whitespace-nowrap select-none',
        'press disabled:pointer-events-none disabled:opacity-60',
        match ($variant) {
            'secondary' => 'border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700',
            'ghost' => 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800',
            'danger' => 'bg-red-600 text-white shadow-sm hover:bg-red-700',
            default => 'bg-primary-600 text-white shadow-sm hover:bg-primary-700',
        },
        match ($size) {
            'sm' => 'min-h-9 px-3.5 text-sm',
            'lg' => 'min-h-12 px-6 text-base',
            'icon' => 'size-10',
            default => 'min-h-10 px-5 text-sm',
        },
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button
        type="{{ $type }}"
        @disabled($disabled || $loading)
        @if ($loading) aria-busy="true" @endif
        {{ $attributes->class($classes) }}
    >
        @if ($loading)
            <svg class="absolute size-4 animate-spin" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" opacity="0.3" />
                <path d="M22 12a10 10 0 0 1-10 10" stroke="currentColor" stroke-width="3" fill="none" />
            </svg>
        @endif

        <span @class(['inline-flex items-center gap-2', 'invisible' => $loading])>{{ $slot }}</span>
    </button>
@endif
