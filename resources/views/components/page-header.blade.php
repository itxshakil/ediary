@props(['title', 'subtitle' => null])

<header {{ $attributes->class(['mb-6 flex items-center justify-between gap-4']) }}>
    <div class="min-w-0">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex shrink-0 items-center gap-2">{{ $actions }}</div>
    @endisset
</header>
