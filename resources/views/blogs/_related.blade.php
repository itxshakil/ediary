<div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Articles</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-900 dark:text-gray-100">
        @foreach($related as $article)
            <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                <h4 class="font-bold text-xl mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    <a href="{{ $article['url'] }}">
                        {{ $article['title'] }}
                    </a>
                </h4>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-4">
                    {{ Str::limit($article['description'], 120) }}
                </p>
                <a href="{{ $article['url'] }}" class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:underline flex items-center gap-1">
                    Read article
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        @endforeach
    </div>
</div>
