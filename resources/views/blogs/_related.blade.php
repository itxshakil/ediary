@php
    $relatedPosts = collect($post['related'] ?? [])->mapWithKeys(fn (string $slug) => [$slug => config("blog.posts.{$slug}")])->filter();
@endphp

@if ($relatedPosts->isNotEmpty())
    <div class="mt-16 border-t border-gray-100 pt-10 dark:border-gray-700/50">
        <h3 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Related Articles</h3>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            @foreach ($relatedPosts as $slug => $article)
                @include('blogs._card', ['slug' => $slug, 'post' => $article, 'heading' => 'h4', 'badge' => false, 'limit' => 120])
            @endforeach
        </div>
    </div>
@endif
