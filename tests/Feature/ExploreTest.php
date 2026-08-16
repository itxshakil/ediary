<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\Privacy;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ExploreTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function explore_shows_public_entries_with_owner_attribution(): void
    {
        $owner = User::factory()->create(['username' => 'pubowner']);
        Diary::factory()->create([
            'user_id' => $owner->id,
            'entry' => 'A public thought',
            'privacy' => Privacy::Public,
        ]);

        $this->actingAs(User::factory()->create());

        $response = $this->get(route('diary.explore'));

        $response->assertStatus(200);
        $response->assertSee('A public thought');
        $response->assertSee('pubowner');
    }

    #[Test]
    public function explore_hides_unlisted_and_private_entries(): void
    {
        $owner = User::factory()->create();
        Diary::factory()->create([
            'user_id' => $owner->id,
            'entry' => 'An unlisted thought',
            'privacy' => Privacy::Unlisted,
        ]);
        Diary::factory()->create([
            'user_id' => $owner->id,
            'entry' => 'A private thought',
            'privacy' => Privacy::Private,
        ]);

        $this->actingAs(User::factory()->create());

        $response = $this->get(route('diary.explore'));

        $response->assertDontSee('An unlisted thought');
        $response->assertDontSee('A private thought');
    }

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        $this->get(route('diary.explore'))->assertRedirect('/login');
    }
}
