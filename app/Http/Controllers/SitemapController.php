<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

final class SitemapController extends Controller
{
    /**
     * Public pages worth indexing. Blog posts are added from their `blogs.*` route names.
     */
    private const array PAGES = ['/', 'about', 'faq', 'security', 'for-students', 'contact', 'blog'];

    public function index(): Response
    {
        $blogPosts = collect(Route::getRoutes()->getRoutesByName())
            ->filter(fn (RoutingRoute $route, string $name): bool => str_starts_with($name, 'blogs.'))
            ->map(fn (RoutingRoute $route): string => $route->uri());

        $urls = collect(self::PAGES)->merge($blogPosts)->map(fn (string $uri): string => url($uri))->unique()->values();

        return response()->view('sitemap.index', ['urls' => $urls])->header('Content-Type', 'text/xml');
    }
}
