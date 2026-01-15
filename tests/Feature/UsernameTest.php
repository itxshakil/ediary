<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UsernameTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_verified_user_can_change_their_username(): void
    {
        $user = User::factory()->create([
            'username' => 'oldusername',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->put('/username', [
            'username' => 'newusername',
        ]);

        $response->assertRedirect('/home');
        $response->assertSessionHas('flash', 'Username Changed Successfully.');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'newusername',
        ]);
    }

    #[Test]
    public function username_must_be_unique(): void
    {
        User::factory()->create(['username' => 'takenname']);
        $user = User::factory()->create([
            'username' => 'myusername',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->put('/username', [
            'username' => 'takenname',
        ]);

        $response->assertSessionHasErrors('username');
    }

    #[Test]
    public function unverified_user_cannot_change_username(): void
    {
        $user = User::factory()->create([
            'username' => 'oldusername',
            'email_verified_at' => null,
        ]);

        $this->actingAs($user);

        $response = $this->put('/username', [
            'username' => 'newusername',
        ]);

        $response->assertRedirect('/email/verify');
    }
}
