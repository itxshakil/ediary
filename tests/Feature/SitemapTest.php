<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SitemapTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_access_the_sitemap(): void
    {
        User::factory()->create(['username' => 'johndoe']);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
        $response->assertSee('johndoe');
    }

    #[Test]
    public function it_can_access_the_users_sitemap(): void
    {
        User::factory()->create(['username' => 'janedoe']);

        $response = $this->get('/sitemap.xml/users');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
        $response->assertSee('janedoe');
    }
}
