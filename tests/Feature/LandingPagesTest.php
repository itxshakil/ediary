<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class LandingPagesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function each_feature_page_renders_its_copy_and_a_signup_call(): void
    {
        foreach (config('landing-pages.pages') as $slug => $page) {
            $this->get("/{$slug}")
                ->assertOk()
                ->assertSeeHtml('<title>' . e($page['headline']) . ' | Ediary</title>')
                ->assertSee($page['title'])
                ->assertSee($page['faqs'][0]['q'])
                ->assertSee($page['cta']);

            $this->assertLessThanOrEqual(51, mb_strlen($page['headline']), "{$slug} headline");
            $this->assertLessThanOrEqual(155, mb_strlen($page['meta_description']), "{$slug} description");
        }
    }

    #[Test]
    public function the_private_diary_page_does_not_overclaim_encryption(): void
    {
        $this->get('/private-diary')->assertSee('not end-to-end encrypted');
        $this->get('/voice-journal')->assertSee('Google, for Chrome');
    }

    #[Test]
    public function feature_pages_are_listed_in_the_sitemap_and_footer(): void
    {
        $sitemap = $this->get('/sitemap.xml');
        $about = $this->get('/about');

        foreach (array_keys(config('landing-pages.pages')) as $slug) {
            $sitemap->assertSeeHtml('<loc>' . url($slug) . '</loc>');
            $about->assertSeeHtml('href="/' . $slug . '"');
        }
    }
}
