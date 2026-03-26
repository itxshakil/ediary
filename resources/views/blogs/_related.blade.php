<div class="mt-16 pt-10 border-t border-gray-100 dark:border-gray-700/50">
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Articles</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($related as $article)
            <div class="blog-card group">
                <div class="blog-card-body">
                    @isset($article['badge'])
                        <span class="blog-badge blog-badge-{{ $article['badge_color'] ?? 'blue' }}">{{ $article['badge'] }}</span>
                    @endisset
                    <h4 class="blog-card-title">
                        <a href="{{ $article['url'] }}">{{ $article['title'] }}</a>
                    </h4>
                    <p class="blog-card-excerpt">
                        {{ Str::limit($article['description'], 120) }}
                    </p>
                </div>
                <div class="blog-card-footer">
                    <div class="blog-card-author">
                        @isset($article['author'])
                            <span class="blog-card-author-label">Written By</span>
                            <span class="blog-card-author-name">{{ $article['author'] }}</span>
                        @endisset
                    </div>
                    <a href="{{ $article['url'] }}" class="blog-card-arrow" aria-label="Read article">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
