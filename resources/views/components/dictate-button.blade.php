@props(['target'])

{{-- Hidden until the dictation script confirms the browser supports speech recognition. --}}
<div data-dictate hidden {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-x-3 gap-y-1']) }}>
    <button
        type="button"
        id="dictate-{{ $target }}"
        data-dictate-target="{{ $target }}"
        aria-pressed="false"
        aria-describedby="dictate-{{ $target }}-note"
        class="dictate-button inline-flex min-h-10 items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus-visible:ring-2 focus-visible:ring-blue-500/60 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
    >
        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect height="12" rx="3" width="6" x="9" y="3" />
            <path d="M5 11a7 7 0 0 0 14 0M12 18v3" stroke-linecap="round" />
        </svg>
        <span data-dictate-label>Dictate</span>
    </button>
    <span id="dictate-{{ $target }}-status" class="text-xs text-gray-500 dark:text-gray-400" aria-live="polite"></span>
    <p id="dictate-{{ $target }}-note" class="w-full text-xs text-gray-400 dark:text-gray-500">
        Your browser's speech service turns speech into text. Only the text is saved.
        <a href="{{ url('/security#dictation') }}" class="underline hover:text-gray-600 dark:hover:text-gray-300"
            >Learn more</a>
    </p>
</div>
