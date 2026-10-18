<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\Mood;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DiaryFilterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_view_their_entries_by_tag(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $tagged = Diary::factory()->create(['user_id' => $user->id, 'title' => 'Exam prep notes']);
        $tagged->syncTags(['study']);
        Diary::factory()->create(['user_id' => $user->id, 'title' => 'Weekend thoughts']);
        Diary::factory()->create(['user_id' => $other->id, 'title' => 'Someone else study'])->syncTags(['study']);

        $this->actingAs($user)
            ->get(route('diary.tag', 'study'))
            ->assertOk()
            ->assertSee('#study')
            ->assertSee('Exam prep notes')
            ->assertDontSee('Weekend thoughts')
            ->assertDontSee('Someone else study');
    }

    #[Test]
    public function entry_cards_link_to_their_tag_and_mood_pages(): void
    {
        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'mood' => Mood::Happy])->syncTags(['study']);

        $this->actingAs($user)
            ->get('/diaries')->assertOk()->assertSeeHtml('href="' . route('diary.tag', 'study') . '"')->assertSeeHtml('href="' . route('diary.mood', 'happy') . '"');
    }

    #[Test]
    public function a_user_can_view_their_entries_by_mood(): void
    {
        $user = User::factory()->create();

        Diary::factory()->create(['user_id' => $user->id, 'title' => 'Great day', 'mood' => Mood::Happy]);
        Diary::factory()->create(['user_id' => $user->id, 'title' => 'Rough day', 'mood' => Mood::Sad]);

        $this->actingAs($user)
            ->get(route('diary.mood', 'happy'))
            ->assertOk()
            ->assertSee('Happy')
            ->assertSee('Great day')
            ->assertDontSee('Rough day');
    }

    #[Test]
    public function an_unknown_mood_returns_not_found(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/diary/mood/ecstatic')
            ->assertNotFound();
    }

    #[Test]
    public function a_user_can_view_their_stats(): void
    {
        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'mood' => Mood::Calm])->syncTags(['study']);

        $this->actingAs($user)
            ->get(route('diary.stats'))
            ->assertOk()
            ->assertSee('Total entries')
            ->assertSee('#study');
    }

    #[Test]
    public function stats_show_whole_days_since_the_first_entry(): void
    {
        $this->travelTo(now()->setTime(18, 30));
        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id])->forceFill(['created_at' => now()->subDays(12)->setTime(9, 15)])->save();

        $this->actingAs($user)
            ->get(route('diary.stats'))
            ->assertOk()
            ->assertSee('12 days since your first entry')
            ->assertDontSee('-12 days');
    }

    #[Test]
    public function entry_cards_only_collapse_long_entries(): void
    {
        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'entry' => 'A short note.', 'mood' => Mood::Happy]);
        Diary::factory()->create(['user_id' => $user->id, 'entry' => str_repeat('A much longer reflection. ', 20)]);

        $response = $this->actingAs($user)->get('/diaries')->assertOk();

        $this->assertSame(1, mb_substr_count($response->getContent(), '<details class="diary-card-details">'));
        $response->assertSee('3 words')
            ->assertSeeHtml('<span class="diary-card-privacy-label">Private</span>')
            ->assertSeeHtml('href="' . route('diary.mood', 'happy') . '"');
    }

    #[Test]
    public function guests_cannot_view_filtered_pages(): void
    {
        $this->get(route('diary.tag', 'study'))->assertRedirect('/login');
        $this->get(route('diary.mood', 'happy'))->assertRedirect('/login');
        $this->get(route('diary.stats'))->assertRedirect('/login');
    }
}
