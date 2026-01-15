<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SearchTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_search_for_users(): void
    {
        User::factory()->create(['username' => 'johndoe']);
        User::factory()->create(['username' => 'janedoe']);

        $response = $this->get('/search?q=john');

        $response->assertStatus(200);
        $response->assertSee('johndoe');
        $response->assertDontSee('janedoe');
    }

    #[Test]
    public function it_shows_random_users_when_search_query_is_empty(): void
    {
        User::factory()->count(5)->create();

        $response = $this->get('/search');

        $response->assertStatus(200);
    }
}
