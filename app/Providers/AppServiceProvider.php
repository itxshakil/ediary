<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Override;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination.default');

        // Canonicals, sitemap and links must name APP_URL, not whatever path the host rewrote the request to.
        $root = (string) config('app.url');
        URL::forceRootUrl($root);
        if (str_starts_with($root, 'https://')) {
            URL::forceScheme('https');
        }
    }
}
