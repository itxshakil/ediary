<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\Privacy;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class LikeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function authenticated_user_can_like_and_unlike_a_public_entry(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Public,
        ]);

        $this->actingAs(User::factory()->create());

        $this->postJson(route('diary.like', $diary))
            ->assertOk()
            ->assertJson(['liked' => true, 'likes_count' => 1]);

        $this->postJson(route('diary.like', $diary))
            ->assertOk()
            ->assertJson(['liked' => false, 'likes_count' => 0]);
    }

    #[Test]
    public function liking_a_private_entry_is_forbidden_for_non_owners(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Private,
        ]);

        $this->actingAs(User::factory()->create());

        $this->postJson(route('diary.like', $diary))->assertForbidden();
    }
}
