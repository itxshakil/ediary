<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ProfileTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_the_user_profile_page(): void
    {
        $user = User::factory()->create(['username' => 'johndoe']);

        $response = $this->get(route('profile.show', 'johndoe'));

        $response->assertStatus(200);
        $response->assertSee('johndoe');
    }

    #[Test]
    public function a_user_can_update_their_profile(): void
    {
        $user = User::factory()->create(['username' => 'johndoe']);

        $this->actingAs($user);

        $response = $this->post("/profile/johndoe", [
            'name' => 'New Name',
            'bio' => 'This is a new bio for the user.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'name' => 'New Name',
            'bio' => 'This is a new bio for the user.',
        ]);
    }

    #[Test]
    public function a_user_cannot_update_another_users_profile(): void
    {
        $user = User::factory()->create(['username' => 'johndoe']);
        $otherUser = User::factory()->create(['username' => 'janedoe']);

        $this->actingAs($user);

        $response = $this->post("/profile/janedoe", [
            'name' => 'Evil Name',
            'bio' => 'Trying to change another bio.',
        ]);

        $response->assertStatus(403);
    }
}
