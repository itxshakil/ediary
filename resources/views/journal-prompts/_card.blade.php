{{-- One prompt page from config/journal-prompts.php, styled like a blog card. --}}
@php
    $heading ??= 'h2';
    $url = url("journal-prompts/{$slug}");
@endphp

<div class="blog-card group">
    <div class="blog-card-body">
        <span class="blog-badge blog-badge-purple">{{ collect($page['sections'])->flatten()->count() }} prompts</span>
        <{{ $heading }} class="blog-card-title">
            <a href="{{ $url }}">{{ $page['title'] }}</a>
        </{{ $heading }}>
        <p class="blog-card-excerpt">{{ $page['description'] }}</p>
    </div>
    <div class="blog-card-footer">
        <span class="text-sm text-gray-500 dark:text-gray-400">Free, with a write link for each prompt</span>
        <a href="{{ $url }}" class="blog-card-arrow" aria-label="Read {{ $page['title'] }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </a>
    </div>
</div>
