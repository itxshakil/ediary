<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ServiceWorkerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * One missing core asset makes the whole service worker install fail, which silently
     * disables offline support, so every precached URL must exist.
     */
    #[Test]
    public function every_precached_core_asset_exists(): void
    {
        $script = (string) file_get_contents(public_path('service-worker.js'));
        preg_match('/const CORE_ASSETS = \[(.*?)\];/s', $script, $match);
        preg_match_all("/'([^']+)'/", $match[1] ?? '', $urls);

        $this->assertNotEmpty($urls[1], 'Could not find CORE_ASSETS in service-worker.js');

        $this->actingAs(User::factory()->create());

        foreach ($urls[1] as $url) {
            if (is_file(public_path($url))) {
                continue;
            }

            $this->get($url)->assertOk();
        }
    }

    #[Test]
    public function the_build_precache_manifest_lists_existing_assets(): void
    {
        $script = (string) file_get_contents(public_path('build/sw-precache.js'));
        preg_match_all('#"(/build/[^"]+)"#', $script, $assets);

        $this->assertNotEmpty($assets[1]);

        foreach ($assets[1] as $asset) {
            $this->assertFileExists(public_path($asset));
        }
    }
}
