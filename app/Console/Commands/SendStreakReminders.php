<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Diary;
use App\Mail\StreakReminder;
use App\Services\Diary\DiaryAnalyticsService;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

final class SendStreakReminders extends Command
{
    protected $signature = 'diary:send-streak-reminders';

    protected $description = "Email users whose daily streak is about to break because they haven't written today";

    public function handle(DiaryAnalyticsService $service): int
    {
        $atRiskUserIds = Diary::query()
            ->selectRaw('user_id, MAX(DATE(created_at)) as last_entry_date')
            ->groupBy('user_id')
            ->havingRaw('MAX(DATE(created_at)) = ?', [today()->subDay()->toDateString()])
            ->pluck('user_id');

        $users = User::query()
            ->whereIn('id', $atRiskUserIds)
            ->where(function ($query): void {
                $query->whereNull('last_reminder_sent_at')
                    ->orWhereDate('last_reminder_sent_at', '<', today());
            })
            ->get();

        foreach ($users as $user) {
            $streak = $service->streak($user)['current'];
            Mail::to($user)->queue(new StreakReminder($user, $streak));
            $user->forceFill(['last_reminder_sent_at' => now()])->save();
        }

        $this->info(sprintf('Queued %d streak reminders.', $users->count()));

        return self::SUCCESS;
    }
}
