<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

final class SitemapController extends Controller
{
    /**
     * Public pages worth indexing. They carry no lastmod: a guessed date is worse than none.
     */
    private const array PAGES = ['/', 'about', 'faq', 'security', 'for-students', 'contact', 'blog', 'journal-prompts'];

    public function index(): Response
    {
        $pages = collect(self::PAGES)->map(fn (string $uri): array => ['loc' => url($uri), 'lastmod' => null]);

        $posts = collect(config('blog.posts'))
            ->filter(fn (array $post): bool => $post['listed'] ?? true)
            ->map(fn (array $post, string $slug): array => [
                'loc' => url("blogs/{$slug}"),
                'lastmod' => $post['updated'] ?? $post['date'],
            ]);

        $promptPages = collect(config('journal-prompts.pages'))
            ->map(fn (array $page, string $slug): array => [
                'loc' => url("journal-prompts/{$slug}"),
                'lastmod' => $page['updated'] ?? $page['date'],
            ]);

        return response()
            ->view('sitemap.index', ['urls' => $pages->merge($posts->values())->merge($promptPages->values())])
            ->header('Content-Type', 'text/xml');
    }
}
