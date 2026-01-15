<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\Diary;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HomeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function an_authenticated_user_can_access_home_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/home');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    #[Test]
    public function it_calculates_correct_streak(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create entries for today and yesterday
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()]);
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDay()]);

        $response = $this->get('/home');

        $response->assertStatus(200);
        $response->assertViewHas('streak', 2);
    }
}
