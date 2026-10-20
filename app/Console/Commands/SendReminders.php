<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\ReminderKind;
use App\Mail\Reminder;
use App\Services\Diary\DiaryAnalyticsService;
use App\User;
use Carbon\CarbonInterface;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * Runs hourly and emails the writers whose local time is now the reminder hour, at most once a day:
 * a streak about to break, a first-entry nudge on days 1 and 3, or a win-back after 3 and 7 quiet days.
 */
final class SendReminders extends Command
{
    private const int LOCAL_HOUR = 20;

    protected $signature = 'diary:send-reminders';

    protected $description = 'Email evening writing reminders to people for whom it is now evening';

    public function handle(DiaryAnalyticsService $analytics): int
    {
        $eveningZones = collect(DateTimeZone::listIdentifiers(DateTimeZone::ALL_WITH_BC))
            ->filter(fn (string $zone): bool => now($zone)->hour === self::LOCAL_HOUR)
            ->values()
            ->all();

        if ($eveningZones === []) {
            $this->info('Queued 0 reminders.');

            return self::SUCCESS;
        }

        $sent = 0;

        User::query()
            ->where('reminders_enabled', operator: true)
            ->where(function (Builder $query) use ($eveningZones): void {
                $query->whereIn('timezone', $eveningZones);
                if (in_array(config('app.user_timezone'), $eveningZones, strict: true)) {
                    $query->orWhereNull('timezone');
                }
            })
            ->withMax('diaries', 'created_at')
            ->chunkById(200, function (Collection $users) use ($analytics, &$sent): void {
                /** @var User $user */
                foreach ($users as $user) {
                    $kind = $this->reminderFor($user);
                    if (! $kind instanceof ReminderKind || $this->remindedToday($user)) {
                        continue;
                    }

                    $streak = $kind === ReminderKind::Streak ? $analytics->streak($user)['current'] : null;
                    Mail::to($user)->queue(new Reminder($user, $kind, $streak));
                    $user->forceFill(['last_reminder_sent_at' => now()])->save();
                    $sent++;
                }
            });

        $this->info(sprintf('Queued %d reminders.', $sent));

        return self::SUCCESS;
    }

    private function reminderFor(User $user): ?ReminderKind
    {
        $lastEntry = $user->getAttribute('diaries_max_created_at');

        if ($lastEntry === null) {
            return in_array($this->localDaysSince($user, $user->created_at ?? now()), [1, 3], strict: true) ? ReminderKind::FirstEntry : null;
        }

        return match ($this->localDaysSince($user, Carbon::parse($lastEntry, 'UTC'))) {
            1 => ReminderKind::Streak,
            3, 7 => ReminderKind::WinBack,
            default => null,
        };
    }

    private function remindedToday(User $user): bool
    {
        return $user->last_reminder_sent_at !== null && $this->localDaysSince($user, $user->last_reminder_sent_at) === 0;
    }

    /**
     * Whole calendar days between a moment and today, both in the writer's timezone.
     */
    private function localDaysSince(User $user, CarbonInterface|string $moment): int
    {
        $timezone = $user->localTimezone();

        return (int) Carbon::parse($moment, 'UTC')->setTimezone($timezone)->startOfDay()->diffInDays(now($timezone)->startOfDay());
    }
}
