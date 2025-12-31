@props([
    'type' => 'button',
    'disabled' => false,
])

<button
    type="{{ $type }}"
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => '
            inline-flex items-center justify-center gap-2
            py-2 px-4 rounded-full
            text-sm font-medium

            bg-gray-100 dark:bg-gray-700
            text-gray-800 dark:text-gray-200

            hover:bg-gray-200 dark:hover:bg-gray-600
            active:scale-[0.96]

            focus:outline-none
            focus:ring-4 focus:ring-gray-400/20

            disabled:opacity-60 disabled:cursor-not-allowed

            transition-all duration-150 ease-out
        '
    ]) }}
>
    {{ $slot }}
</button>
