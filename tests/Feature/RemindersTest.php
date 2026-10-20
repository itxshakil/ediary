<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\ReminderKind;
use App\Mail\Reminder;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RemindersTest extends TestCase
{
    use RefreshDatabase;

    /** 14:30 UTC is 20:00 in Kolkata. */
    private const string KOLKATA_EVENING = '2026-10-20 14:30';

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    #[Test]
    public function a_streak_at_risk_gets_an_evening_reminder(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1);

        $this->runAt(self::KOLKATA_EVENING);

        $this->assertReminded($user, ReminderKind::Streak);
        $this->assertNotNull($user->fresh()->last_reminder_sent_at);
    }

    #[Test]
    public function reminders_wait_for_the_writers_own_evening(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1, timezone: 'Europe/London');

        $this->runAt(self::KOLKATA_EVENING);
        Mail::assertNothingQueued();

        $this->runAt('2026-10-20 19:30'); // 20:30 in London (BST)
        $this->assertReminded($user, ReminderKind::Streak);
    }

    #[Test]
    public function writers_without_a_known_timezone_use_the_default(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1, timezone: null);

        $this->runAt(self::KOLKATA_EVENING);

        $this->assertReminded($user, ReminderKind::Streak);
    }

    #[Test]
    public function nobody_who_wrote_today_is_reminded(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1);
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::parse('2026-10-20 04:00', 'UTC')]);

        $this->runAt(self::KOLKATA_EVENING);

        Mail::assertNothingQueued();
    }

    #[Test]
    public function new_writers_without_an_entry_get_a_nudge_on_day_one_and_three(): void
    {
        $dayOne = $this->newcomer(signedUpDaysAgo: 1);
        $dayThree = $this->newcomer(signedUpDaysAgo: 3);
        $dayTwo = $this->newcomer(signedUpDaysAgo: 2);

        $this->runAt(self::KOLKATA_EVENING);

        $this->assertReminded($dayOne, ReminderKind::FirstEntry);
        $this->assertReminded($dayThree, ReminderKind::FirstEntry);
        Mail::assertNotQueued(Reminder::class, fn (Reminder $mail): bool => $mail->user->is($dayTwo));
    }

    #[Test]
    public function lapsed_writers_hear_from_us_after_three_and_seven_days_only(): void
    {
        $three = $this->writer(lastWroteDaysAgo: 3);
        $seven = $this->writer(lastWroteDaysAgo: 7);
        $five = $this->writer(lastWroteDaysAgo: 5);
        $thirty = $this->writer(lastWroteDaysAgo: 30);

        $this->runAt(self::KOLKATA_EVENING);

        $this->assertReminded($three, ReminderKind::WinBack);
        $this->assertReminded($seven, ReminderKind::WinBack);
        Mail::assertNotQueued(Reminder::class, fn (Reminder $mail): bool => $mail->user->is($five) || $mail->user->is($thirty));
    }

    #[Test]
    public function nobody_gets_two_reminders_in_a_day(): void
    {
        $this->writer(lastWroteDaysAgo: 1);

        $this->runAt(self::KOLKATA_EVENING);
        $this->runAt('2026-10-20 14:45');

        Mail::assertQueuedCount(1);
    }

    #[Test]
    public function writers_who_turned_reminders_off_are_left_alone(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1);
        $user->update(['reminders_enabled' => false]);

        $this->runAt(self::KOLKATA_EVENING);

        Mail::assertNothingQueued();
    }

    #[Test]
    public function the_reminder_links_to_writing_and_unsubscribing_but_never_quotes_entries(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1);
        $user->diaries()->first()->update(['entry' => 'My secret thoughts']);

        $html = new Reminder($user, ReminderKind::Streak, streak: 4)->render();

        $this->assertStringContainsString('4-day', $html);
        $this->assertStringContainsString(route('diary.create'), $html);
        $this->assertStringContainsString('reminders/unsubscribe', $html);
        $this->assertStringNotContainsString('My secret thoughts', $html);
    }

    #[Test]
    public function reminders_carry_one_click_unsubscribe_headers(): void
    {
        $headers = new Reminder($this->writer(lastWroteDaysAgo: 1), ReminderKind::Streak, streak: 1)->headers()->text;

        $this->assertStringContainsString('reminders/unsubscribe', $headers['List-Unsubscribe']);
        $this->assertSame('List-Unsubscribe=One-Click', $headers['List-Unsubscribe-Post']);
    }

    #[Test]
    public function the_unsubscribe_link_asks_first_then_turns_reminders_off(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1);
        $link = URL::signedRoute('reminders.unsubscribe', $user);

        $this->get($link)->assertOk()->assertSee('Turn off reminders');
        $this->assertTrue($user->fresh()->reminders_enabled);

        $this->post($link)->assertOk()->assertSee('Reminders are off');
        $this->assertFalse($user->fresh()->reminders_enabled);
    }

    #[Test]
    public function the_unsubscribe_link_cannot_be_forged(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1);

        $this->post(route('reminders.unsubscribe', $user))->assertForbidden();
        $this->assertTrue($user->fresh()->reminders_enabled);
    }

    #[Test]
    public function writers_can_choose_reminders_and_their_timezone_in_settings(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1);

        $this->actingAs($user)->get('/settings')->assertSee('Email reminders')->assertSee('Asia/Kolkata');

        $this->actingAs($user)
            ->put(route('settings.reminders'), ['timezone' => 'Europe/Berlin'])
            ->assertRedirect('/settings');

        $user->refresh();
        $this->assertFalse($user->reminders_enabled);
        $this->assertSame('Europe/Berlin', $user->timezone);

        $this->actingAs($user)->put(route('settings.reminders'), ['reminders_enabled' => '1', 'timezone' => 'Nowhere/Land'])
            ->assertSessionHasErrors('timezone');
    }

    #[Test]
    public function a_legacy_timezone_alias_stays_selected_in_settings(): void
    {
        $user = $this->writer(lastWroteDaysAgo: 1, timezone: 'Asia/Calcutta');

        $this->actingAs($user)->get('/settings')->assertSeeHtml('<option value="Asia/Calcutta" selected');
    }

    #[Test]
    public function the_command_runs_every_hour(): void
    {
        $this->artisan('schedule:list')->expectsOutputToContain('diary:send-reminders');
        $event = collect(app(Schedule::class)->events())
            ->first(fn ($event): bool => str_contains((string) $event->command, 'diary:send-reminders'));

        $this->assertSame('0 * * * *', $event->expression);
    }

    private function writer(int $lastWroteDaysAgo, ?string $timezone = 'Asia/Kolkata'): User
    {
        $this->travelTo(Carbon::parse(self::KOLKATA_EVENING, 'UTC'));
        $user = User::factory()->create(['timezone' => $timezone, 'created_at' => now()->subMonths(2)]);
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDays($lastWroteDaysAgo)->setTime(6, 0)]);

        return $user;
    }

    private function newcomer(int $signedUpDaysAgo): User
    {
        $this->travelTo(Carbon::parse(self::KOLKATA_EVENING, 'UTC'));

        return User::factory()->create(['timezone' => 'Asia/Kolkata', 'created_at' => now()->subDays($signedUpDaysAgo)->setTime(6, 0)]);
    }

    private function runAt(string $utc): void
    {
        $this->travelTo(Carbon::parse($utc, 'UTC'));
        $this->artisan('diary:send-reminders')->assertSuccessful();
    }

    private function assertReminded(User $user, ReminderKind $kind): void
    {
        Mail::assertQueued(Reminder::class, fn (Reminder $mail): bool => $mail->user->is($user) && $mail->kind === $kind);
    }
}
