@inject('navigation', App\Support\Navigation::class)

{{-- Mobile-only bottom navigation for signed-in people. --}}
<nav class="tab-bar" aria-label="Primary">
    @foreach ($navigation->journal() as $item)
        <a
            href="{{ $item['url'] }}"
            @class(['tab-bar-item', 'tab-bar-item--write' => $item['key'] === 'write'])
            @if ($item['active']) aria-current="page" @endif
        >
            <span class="tab-bar-icon" aria-hidden="true">
                <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
            </span>
            <span class="tab-bar-label">{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>
