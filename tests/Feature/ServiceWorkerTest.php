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
        preg_match_all('/const CORE_(?:FILES|PAGES) = \[(.*?)\];/s', $script, $lists);
        preg_match_all("/'([^']+)'/", implode(',', $lists[1]), $urls);

        $this->assertCount(2, $lists[1], 'Could not find CORE_FILES and CORE_PAGES in service-worker.js');

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

    /**
     * Browsers only offer to install the app when the linked manifest is valid and its icons load.
     */
    #[Test]
    public function the_layout_links_one_valid_manifest_whose_files_exist(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        preg_match_all('/<link rel="manifest" href="([^"]+)"/', (string) $html, $links);
        $this->assertCount(1, $links[1], 'Exactly one manifest should be linked');

        $manifest = json_decode((string) file_get_contents(public_path($links[1][0])), associative: true, flags: JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('id', $manifest);
        $this->assertArrayHasKey('theme_color', $manifest);
        $sizes = array_column($manifest['icons'], 'sizes');
        $this->assertContains('192x192', $sizes);
        $this->assertContains('512x512', $sizes);

        foreach ([...$manifest['icons'], ...$manifest['screenshots'] ?? []] as $image) {
            $this->assertFileExists(public_path($image['src']));
        }
    }

    #[Test]
    public function pushed_scripts_are_output_once(): void
    {
        $html = (string) $this->get('/register')->assertOk()->getContent();

        $this->assertSame(1, mb_substr_count($html, "document.getElementById('username')"));
    }
}
