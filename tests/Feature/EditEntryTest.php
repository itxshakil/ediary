<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\Mood;
use App\Enums\Privacy;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class EditEntryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function writers_can_open_their_entry_for_editing(): void
    {
        [$user, $diary] = $this->entry();

        $this->actingAs($user)->get(route('diary.edit', $diary))
            ->assertOk()
            ->assertSee('Edit entry')
            ->assertSee('A typo hre.')
            ->assertSee('travel');
    }

    #[Test]
    public function writers_can_fix_an_entry(): void
    {
        [$user, $diary] = $this->entry();

        $this->actingAs($user)
            ->put(route('diary.update', $diary), [
                'title' => 'Fixed',
                'entry' => 'A typo here.',
                'mood' => 'calm',
                'tags' => 'travel, family',
                'privacy' => 'public',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHas('success');

        $diary->refresh();
        $this->assertSame('Fixed', $diary->title);
        $this->assertSame('A typo here.', $diary->entry);
        $this->assertSame(Mood::Calm, $diary->mood);
        $this->assertSame(Privacy::Public, $diary->privacy);
        $this->assertEqualsCanonicalizing(['travel', 'family'], $diary->tags->pluck('name')->all());
    }

    #[Test]
    public function editing_keeps_the_day_the_entry_was_written(): void
    {
        [$user, $diary] = $this->entry();
        $writtenAt = $diary->created_at->toDateTimeString();

        $this->actingAs($user)->put(route('diary.update', $diary), ['entry' => 'Changed.', 'created_at' => '2020-01-01']);

        $this->assertSame($writtenAt, $diary->fresh()->created_at->toDateTimeString());
    }

    #[Test]
    public function an_entry_still_needs_text(): void
    {
        [$user, $diary] = $this->entry();

        $this->actingAs($user)->put(route('diary.update', $diary), ['entry' => ''])->assertSessionHasErrors('entry');

        $this->assertSame('A typo hre.', $diary->fresh()->entry);
    }

    #[Test]
    public function writers_can_delete_an_entry(): void
    {
        [$user, $diary] = $this->entry();

        $this->actingAs($user)->delete(route('diary.destroy', $diary))
            ->assertRedirect(route('home'))
            ->assertSessionHas('success');

        $this->assertModelMissing($diary);
        $this->assertSame(0, DB::table('taggables')->where('taggable_id', $diary->id)->count());
    }

    #[Test]
    public function nobody_else_can_see_edit_or_delete_an_entry(): void
    {
        [, $diary] = $this->entry(Privacy::Public);
        $stranger = User::factory()->create();

        $this->actingAs($stranger)->get(route('diary.edit', $diary))->assertNotFound();
        $this->actingAs($stranger)->put(route('diary.update', $diary), ['entry' => 'Hacked'])->assertNotFound();
        $this->actingAs($stranger)->delete(route('diary.destroy', $diary))->assertNotFound();

        $this->assertSame('A typo hre.', $diary->fresh()->entry);
    }

    #[Test]
    public function guests_are_sent_to_log_in(): void
    {
        [, $diary] = $this->entry();

        $this->get(route('diary.edit', $diary))->assertRedirect(route('login'));
        $this->delete(route('diary.destroy', $diary))->assertRedirect(route('login'));
    }

    #[Test]
    public function the_writers_own_cards_link_to_edit(): void
    {
        [$user, $diary] = $this->entry(Privacy::Public);

        $this->actingAs($user)->get('/home')->assertSeeHtml('href="' . route('diary.edit', $diary) . '"');
        $this->get(route('diary.public', $diary))->assertDontSeeHtml(route('diary.edit', $diary));
    }

    /**
     * @return array{User, Diary}
     */
    private function entry(Privacy $privacy = Privacy::Private): array
    {
        $user = User::factory()->create();
        $diary = Diary::factory()->create(['user_id' => $user->id, 'entry' => 'A typo hre.', 'privacy' => $privacy]);
        $diary->syncTags(['travel']);

        return [$user, $diary];
    }
}
