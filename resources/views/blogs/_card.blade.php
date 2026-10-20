{{-- One post card from config/blog.php. $heading keeps the outline right for the page it sits on. --}}
@php
    $heading ??= 'h2';
    $badge ??= true;
    $url = url("blogs/{$slug}");
@endphp

<div class="blog-card group">
    <div class="blog-card-body">
        @if ($badge)
            <span class="blog-badge blog-badge-{{ $post['badge_color'] ?? 'blue' }}">{{ $post['badge'] }}</span>
        @endif
        <{{ $heading }} class="blog-card-title">
            <a href="{{ $url }}">{{ $post['title'] }}</a>
        </{{ $heading }}>
        <p class="blog-card-excerpt">
            {{ isset($limit) ? Str::limit($post['description'], $limit) : $post['description'] }}
        </p>
    </div>
    <div class="blog-card-footer">
        <div class="blog-card-author">
            <span class="blog-card-author-label">Written By</span>
            <span class="blog-card-author-name">{{ $post['author'] }}</span>
        </div>
        <a href="{{ $url }}" class="blog-card-arrow" aria-label="Read {{ $post['title'] }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </a>
    </div>
</div>
