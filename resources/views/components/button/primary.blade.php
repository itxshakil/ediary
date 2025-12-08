@props([
    'type' => 'button',
    'loading' => false,
    'disabled' => false,
])

<button
    type="{{ $type }}"
    @disabled($disabled || $loading)
    {{ $attributes->merge([
        'class' => '
            relative inline-flex items-center justify-center gap-2
            py-2 px-4 rounded-full
            text-sm font-medium text-white

            bg-gradient-to-b from-blue-500 to-blue-600
            hover:from-blue-600 hover:to-blue-700

            active:scale-[0.96]

            focus:outline-none
            focus:ring-4 focus:ring-blue-500/20

            disabled:opacity-60 disabled:cursor-not-allowed

            transition-all duration-150 ease-out
        '
    ]) }}
>
    {{-- Loading spinner --}}
    @if($loading)
        <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" fill="none" opacity="0.3"/>
            <path d="M22 12a10 10 0 0 1-10 10" stroke="white" stroke-width="3" fill="none"/>
        </svg>
    @endif

    <span class="{{ $loading ? 'opacity-0' : '' }}">
        {{ $slot }}
    </span>
</button>
