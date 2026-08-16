<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Mail\StreakReminder;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SendStreakRemindersTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_queues_a_reminder_for_a_user_whose_streak_is_at_risk(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDay()]);

        $this->artisan('diary:send-streak-reminders')->assertSuccessful();

        Mail::assertQueued(StreakReminder::class, fn (StreakReminder $mail): bool => $mail->user->is($user));
        $this->assertNotNull($user->fresh()->last_reminder_sent_at);
    }

    #[Test]
    public function it_does_not_email_a_user_who_already_wrote_today(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDay()]);
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()]);

        $this->artisan('diary:send-streak-reminders');

        Mail::assertNothingQueued();
    }

    #[Test]
    public function it_does_not_email_a_user_who_lapsed_more_than_a_day_ago(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDays(3)]);

        $this->artisan('diary:send-streak-reminders');

        Mail::assertNothingQueued();
    }

    #[Test]
    public function it_does_not_double_remind_a_user_already_reminded_today(): void
    {
        Mail::fake();

        $user = User::factory()->create(['last_reminder_sent_at' => now()]);
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDay()]);

        $this->artisan('diary:send-streak-reminders');

        Mail::assertNothingQueued();
    }
}
