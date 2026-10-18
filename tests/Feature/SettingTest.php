<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function the_settings_page_has_a_working_username_field_and_data_links(): void
    {
        $user = User::factory()->create(['username' => 'janedoe', 'email_verified_at' => now()]);

        $this->actingAs($user)
            ->get('/settings')
            ->assertOk()
            ->assertSeeHtml('name="username"')
            ->assertSeeHtml('value="janedoe"')
            ->assertSeeHtml('href="' . route('diary.export', ['format' => 'csv']) . '"')
            ->assertSeeHtml('href="' . url('/password/change') . '"');
    }
}
