@props(['title', 'subtitle' => null, 'eyebrow' => null])

<div {{ $attributes->class(['bg-primary-600 relative overflow-hidden py-20']) }}>
    <div
        class="absolute inset-0 opacity-10"
        style="
            background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0);
            background-size: 40px 40px;
        "
        aria-hidden="true"
    ></div>
    <div class="relative container mx-auto px-4 text-center">
        @if ($eyebrow)
            <p class="text-primary-200 mb-4 text-sm font-semibold tracking-wider uppercase">{{ $eyebrow }}</p>
        @endif
        <h1 class="mb-6 text-4xl font-extrabold text-white md:text-6xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="text-primary-100 mx-auto max-w-2xl text-xl">{{ $subtitle }}</p>
        @endif
        @if ($slot->isNotEmpty())
            <div class="mt-10">{{ $slot }}</div>
        @endif
    </div>
</div>
