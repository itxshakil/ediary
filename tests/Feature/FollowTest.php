<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class FollowTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function an_authenticated_user_can_follow_another_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('follow.store', $otherUser->username));

        $response->assertNoContent();
        $this->assertTrue($otherUser->profile->follower->contains($user->id));
    }

    #[Test]
    public function an_authenticated_user_can_unfollow_another_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        
        $otherUser->profile->follower()->attach($user->id);

        $this->actingAs($user);

        $response = $this->post(route('follow.store', $otherUser->username));

        $response->assertNoContent();
        $this->assertFalse($otherUser->profile->refresh()->follower->contains($user->id));
    }

    #[Test]
    public function an_unauthenticated_user_cannot_follow_another_user(): void
    {
        $otherUser = User::factory()->create();

        $response = $this->post(route('follow.store', $otherUser->username));

        $response->assertRedirect('/login');
    }
}
