<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SitemapTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lists_public_pages_and_blog_posts(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
        $response->assertSeeHtml('<loc>' . url('/') . '</loc>');
        $response->assertSeeHtml('<loc>' . url('/for-students') . '</loc>');
        $response->assertSeeHtml('<loc>' . url('/security') . '</loc>');
        $response->assertSeeHtml('<loc>' . route('blogs.how-to-keep-a-study-journal') . '</loc>');
    }

    #[Test]
    public function blog_posts_carry_their_last_modified_date(): void
    {
        $this->get('/sitemap.xml')->assertSeeInOrder([
            '<loc>' . route('blogs.how-to-keep-a-study-journal') . '</loc>',
            '<lastmod>2026-10-18</lastmod>',
        ], escape: false);
    }

    #[Test]
    public function unlisted_blog_posts_are_left_out(): void
    {
        $this->get('/sitemap.xml')->assertDontSeeHtml(route('blogs.how-to-write'));
    }

    #[Test]
    public function it_leaves_out_private_utility_and_profile_pages(): void
    {
        User::factory()->create(['username' => 'johndoe']);

        $response = $this->get('/sitemap.xml');

        foreach (['/home', '/settings', '/diary/export', '/password/reset', '/success', '/up', '/_debugbar', '/user/johndoe', '/explore'] as $path) {
            $response->assertDontSeeHtml('<loc>' . url($path));
        }
    }

    #[Test]
    public function profile_pages_are_not_indexed(): void
    {
        User::factory()->create(['username' => 'johndoe']);

        $this->get('/user/johndoe')->assertOk()->assertSeeHtml('<meta name="robots" content="noindex, follow" />');
    }
}
