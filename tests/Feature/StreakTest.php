<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Services\Diary\DiaryAnalyticsService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class StreakTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function no_entries_means_no_streak(): void
    {
        $this->assertSame(['current' => 0, 'longest' => 0, 'todayWritten' => false], $this->streakFor($this->writer()));
    }

    #[Test]
    public function a_single_entry_today_is_a_one_day_streak(): void
    {
        $user = $this->writer();
        $this->writeOn($user, '2026-10-20 09:00');

        $this->assertSame(['current' => 1, 'longest' => 1, 'todayWritten' => true], $this->streakFor($user));
    }

    #[Test]
    public function a_missed_day_breaks_the_run(): void
    {
        $user = $this->writer();
        $this->writeOn($user, '2026-10-20 09:00');
        $this->writeOn($user, '2026-10-18 09:00');

        $this->assertSame(['current' => 1, 'longest' => 1, 'todayWritten' => true], $this->streakFor($user));
    }

    #[Test]
    public function the_streak_survives_until_today_is_over(): void
    {
        $user = $this->writer();
        $this->writeOn($user, '2026-10-19 09:00');
        $this->writeOn($user, '2026-10-18 09:00');

        $this->assertSame(['current' => 2, 'longest' => 2, 'todayWritten' => false], $this->streakFor($user));
    }

    #[Test]
    public function the_longest_run_is_remembered_after_it_ends(): void
    {
        $user = $this->writer();
        foreach (['2026-09-01', '2026-09-02', '2026-09-03', '2026-09-04', '2026-10-19', '2026-10-20'] as $day) {
            $this->writeOn($user, "{$day} 09:00");
        }

        $this->writeOn($user, '2026-10-20 18:00');

        $this->assertSame(['current' => 2, 'longest' => 4, 'todayWritten' => true], $this->streakFor($user));
    }

    #[Test]
    public function days_follow_the_writers_timezone(): void
    {
        // 23:30 in Kolkata on the 19th is 18:00 UTC; 00:30 on the 20th is 19:00 UTC the same UTC day.
        $user = $this->writer('Asia/Kolkata');
        $this->writeOn($user, '2026-10-19 18:00');
        $this->writeOn($user, '2026-10-19 19:00');

        $this->assertSame(['current' => 2, 'longest' => 2, 'todayWritten' => true], $this->streakFor($user, now: '2026-10-19 20:00'));
    }

    #[Test]
    public function the_home_page_shows_the_writers_streak(): void
    {
        $user = $this->writer();
        $this->writeOn($user, '2026-10-20 09:00');
        $this->writeOn($user, '2026-10-19 09:00');

        $this->actingAs($user)->get('/home')->assertViewHas('streak', 2)->assertViewHas('longestStreak', 2);
    }

    private function writer(string $timezone = 'UTC'): User
    {
        $this->travelTo(Carbon::parse('2026-10-20 12:00', 'UTC'));

        return User::factory()->create(['timezone' => $timezone]);
    }

    private function writeOn(User $user, string $utc): void
    {
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::parse($utc, 'UTC')]);
    }

    /**
     * @return array{current:int,longest:int,todayWritten:bool}
     */
    private function streakFor(User $user, ?string $now = null): array
    {
        if ($now !== null) {
            $this->travelTo(Carbon::parse($now, 'UTC'));
        }

        return app(DiaryAnalyticsService::class)->streak($user);
    }
}
