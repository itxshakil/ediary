<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use RuntimeException;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        // A cached config ignores phpunit.xml, so tests would run against the real database with
        // CSRF on. Refuse instead of quietly wiping local data.
        if ($app->configurationIsCached()) {
            throw new RuntimeException('Configuration is cached; run `php artisan config:clear` before testing.');
        }

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
