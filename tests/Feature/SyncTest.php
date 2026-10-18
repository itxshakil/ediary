<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\Mood;
use App\Enums\Privacy;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SyncTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function an_offline_entry_syncs_with_all_its_fields(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('diary.sync'), [
                'title' => 'Offline exam notes',
                'entry' => 'Written on the train with no signal.',
                'mood' => 'calm',
                'tags' => 'study,exams',
                'privacy' => 'followers',
                'created_at' => '2026-10-17T08:30:00.000Z',
            ])
            ->assertCreated()
            ->assertJsonPath('success', expect: true);

        $diary = Diary::sole();
        $this->assertSame($user->id, $diary->user_id);
        $this->assertSame('Offline exam notes', $diary->title);
        $this->assertSame('Written on the train with no signal.', $diary->entry);
        $this->assertSame(Mood::Calm, $diary->mood);
        $this->assertSame(Privacy::Followers, $diary->privacy);
        $this->assertEqualsCanonicalizing(['study', 'exams'], $diary->tags->pluck('name')->all());
        $this->assertSame('2026-10-17 08:30:00', $diary->created_at->utc()->toDateTimeString());
    }

    #[Test]
    public function a_synced_entry_without_privacy_stays_private(): void
    {
        $this->actingAs(User::factory()->create())
            ->postJson(route('diary.sync'), ['entry' => 'Just the text.'])
            ->assertCreated();

        $this->assertSame(Privacy::Private, Diary::sole()->privacy);
    }

    #[Test]
    public function a_synced_entry_is_validated_like_a_normal_entry(): void
    {
        $this->actingAs(User::factory()->create())
            ->postJson(route('diary.sync'), ['entry' => ['not' => 'a string'], 'mood' => 'ecstatic'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['entry', 'mood']);

        $this->assertSame(0, Diary::count());
    }

    #[Test]
    public function guests_cannot_sync_entries(): void
    {
        $this->postJson(route('diary.sync'), ['entry' => 'Hello'])->assertUnauthorized();
    }
}
