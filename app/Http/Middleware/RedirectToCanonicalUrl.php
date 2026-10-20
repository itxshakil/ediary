<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gives every page one address: no /public or /index.php prefix and no trailing slash.
 *
 * The host rewrites the site root into public/, so /public/about reaches the app as "about"
 * and Apache's own trailing-slash redirect points at /public/... These would otherwise be
 * indexable duplicates, so they get a permanent redirect to the clean URL on APP_URL.
 */
final class RedirectToCanonicalUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        $uri = $request->getRequestUri();
        $path = (string) parse_url($uri, PHP_URL_PATH);
        $canonical = $this->canonicalPath($path);

        if ($canonical === $path) {
            return $next($request);
        }

        $query = parse_url($uri, PHP_URL_QUERY);

        return redirect()->to(
            mb_rtrim((string) config('app.url'), '/') . $canonical . (is_string($query) ? '?' . $query : ''),
            Response::HTTP_MOVED_PERMANENTLY,
        );
    }

    private function canonicalPath(string $path): string
    {
        $path = (string) preg_replace('#^/(public|index\.php)(?=/|$)#', '', $path);
        $path = (string) preg_replace('#^/index\.php(?=/|$)#', '', $path);
        $path = mb_rtrim($path, '/');

        return $path === '' ? '/' : $path;
    }
}
