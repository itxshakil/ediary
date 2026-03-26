<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Mood;
use App\User;
use Carbon\Carbon;
use Carbon\Month;
use Carbon\WeekDay;
use DateTimeInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class HomeController
{
    public function __invoke(Request $request): Factory|View
    {
        $user = $request->user();

        $streak = $this->calculateStreak($user);

        return view('home', [
            'entries' => $user->diaries()->latest()->with('tags')->paginate(8),
            'streak' => $streak['current'],
            'longestStreak' => $streak['longest'],
            'todayWritten' => $streak['todayWritten'],
            'moodData' => $this->getMoodData($user),
        ]);
    }

    private function getMoodData(User $user): array
    {
        $days = collect();
        $moodsByDate = $user->diaries()
            ->whereNotNull('mood')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->get()
            ->groupBy(fn ($entry) => Carbon::parse($entry->created_at)->toDateString());

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->toDateString();
            $entriesForDay = $moodsByDate->get($dateStr, collect());

            if ($entriesForDay->isNotEmpty()) {
                $moods = $entriesForDay->map(fn ($e) => Mood::from($e->mood))->all();
                $avgScore = (int) round(Mood::averageScore($moods));
                $avgScore = max(-2, min(2, $avgScore));
                $dominantMood = collect($moods)->sortByDesc(fn (Mood $m) => $m->score())->first();
                $days->push([
                    'day'   => $date->format('D'),
                    'date'  => $dateStr,
                    'emoji' => $dominantMood->emoji(),
                    'label' => $dominantMood->label(),
                    'score' => $avgScore,
                ]);
            } else {
                $days->push([
                    'day'   => $date->format('D'),
                    'date'  => $dateStr,
                    'emoji' => null,
                    'label' => null,
                    'score' => null,
                ]);
            }
        }

        // Only return if at least one day has mood data
        $hasMood = $days->contains(fn ($d) => $d['score'] !== null);

        return $hasMood ? $days->all() : [];
    }

    private function calculateStreak(User $user): array
    {
        $entries = $user->diaries()
            ->select(DB::raw('DATE(created_at) as date'))
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->map(fn (DateTimeInterface|WeekDay|Month|string|int|float|null $date): Carbon => Carbon::parse($date));

        $currentStreak = 0;
        $longestStreak = 0;
        $tempStreak = 0;
        $todayWritten = false;

        if ($entries->isEmpty()) {
            return ['current' => 0, 'longest' => 0, 'todayWritten' => false];
        }

        $todayWritten = $entries->first()->isToday();
        $checkDate = $todayWritten ? today() : today()->subDay();

        foreach ($entries as $entryDate) {
            if ($entryDate->isSameDay($checkDate)) {
                $currentStreak++;
                $tempStreak++;
                $checkDate = $checkDate->subDay();
            } else {
                break;
            }
        }

        $checkDate = $entries->first();
        foreach ($entries as $entry) {
            if ($entry->isSameDay($checkDate) || $entry->isSameDay($checkDate->subDay())) {
                $tempStreak++;
                $longestStreak = max($longestStreak, $tempStreak);
            } else {
                $tempStreak = 1;
            }

            $checkDate = $entry->subDay();
        }

        return [
            'current' => $currentStreak,
            'longest' => max($longestStreak, $currentStreak),
            'todayWritten' => $todayWritten,
        ];
    }
}
