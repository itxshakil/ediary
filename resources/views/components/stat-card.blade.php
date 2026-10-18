@props(['label', 'value', 'tone' => 'primary'])

@php
    $iconTone = match ($tone) {
        'purple' => 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400',
        'green' => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
        'orange' => 'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400',
        default => 'bg-primary-100 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400',
    };
@endphp

<x-card {{ $attributes }}>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $label }}</p>
            <p class="mt-1 text-3xl font-bold text-gray-900 tabular-nums dark:text-white">{{ $value }}</p>
        </div>
        @isset($icon)
            <div @class(['grid size-12 shrink-0 place-items-center rounded-xl', $iconTone]) aria-hidden="true">
                {{ $icon }}
            </div>
        @endisset
    </div>
    @if ($slot->isNotEmpty())
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $slot }}</p>
    @endif
</x-card>
