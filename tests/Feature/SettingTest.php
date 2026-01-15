<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SettingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_verified_user_can_access_settings_page(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->get('/settings');

        $response->assertStatus(200);
        $response->assertViewIs('settings.index');
    }

    #[Test]
    public function an_unverified_user_cannot_access_settings_page(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user);

        $response = $this->get('/settings');

        $response->assertRedirect('/email/verify');
    }
}
