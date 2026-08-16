<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\Privacy;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PublicEntryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_can_view_an_unlisted_entry_via_direct_link(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'entry' => 'Unlisted but reachable',
            'privacy' => Privacy::Unlisted,
        ]);

        $response = $this->get(route('diary.public', $diary));

        $response->assertStatus(200);
        $response->assertSee('Unlisted but reachable');
    }

    #[Test]
    public function guest_can_view_a_public_entry(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'entry' => 'Public entry',
            'privacy' => Privacy::Public,
        ]);

        $this->get(route('diary.public', $diary))->assertStatus(200);
    }

    #[Test]
    public function private_entry_returns_not_found_for_non_owner(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Private,
        ]);

        $this->get(route('diary.public', $diary))->assertStatus(404);

        $this->actingAs(User::factory()->create());
        $this->get(route('diary.public', $diary))->assertStatus(404);
    }

    #[Test]
    public function owner_can_always_view_their_own_private_entry(): void
    {
        $owner = User::factory()->create();
        $diary = Diary::factory()->create([
            'user_id' => $owner->id,
            'entry' => 'My private entry',
            'privacy' => Privacy::Private,
        ]);

        $this->actingAs($owner);

        $this->get(route('diary.public', $diary))->assertStatus(200)->assertSee('My private entry');
    }

    #[Test]
    public function viewing_a_public_entry_increments_the_view_count(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Public,
        ]);

        $this->get(route('diary.public', $diary));

        $this->assertSame(1, $diary->fresh()->views_count);
    }
}
