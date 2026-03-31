<?php

declare(strict_types=1);

namespace App\Services\Diary;

use App\Diary;
use App\Enums\Mood;
use App\User;
use Carbon\Carbon;
use Carbon\Month;
use Carbon\WeekDay;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class DiaryAnalyticsService
{
    /**
     * @return array{current:int,longest:int,todayWritten:bool}
     */
    public function streak(User $user): array
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

        if ($entries->isEmpty()) {
            return ['current' => 0, 'longest' => 0, 'todayWritten' => false];
        }

        $todayWritten = $entries->first()->isToday();
        $checkDate = $todayWritten ? today() : today()->subDay();

        foreach ($entries as $entryDate) {
            if ($entryDate->isSameDay($checkDate)) {
                $currentStreak++;
                $tempStreak++;
                $checkDate = $checkDate->copy()->subDay();

                continue;
            }

            break;
        }

        $checkDate = $entries->first()->copy();

        foreach ($entries as $entry) {
            if ($entry->isSameDay($checkDate) || $entry->isSameDay($checkDate->copy()->subDay())) {
                $tempStreak++;
                $longestStreak = max($longestStreak, $tempStreak);
            } else {
                $tempStreak = 1;
            }

            $checkDate = $entry->copy()->subDay();
        }

        return [
            'current' => $currentStreak,
            'longest' => max($longestStreak, $currentStreak),
            'todayWritten' => $todayWritten,
        ];
    }

    /**
     * @param  EloquentCollection<int, Diary> $entries
     * @return array<string, mixed>
     */
    public function stats(User $user, EloquentCollection $entries): array
    {
        $totalEntries = $entries->count();
        $totalWords = $entries->sum(fn ($entry): int => str_word_count((string) $entry->entry));
        $streak = $this->streak($user);

        return [
            'total_entries' => $totalEntries,
            'entries_this_month' => $entries->where('created_at', '>=', now()->startOfMonth())->count(),
            'total_words' => $totalWords,
            'avg_words_per_entry' => $totalEntries > 0 ? (int) round($totalWords / $totalEntries) : 0,
            'active_days' => $entries->pluck('created_at')->map(fn ($date) => $date->format('Y-m-d'))->unique()->count(),
            'days_since_start' => $entries->min('created_at')
                ? now()->diffInDays($entries->min('created_at'))
                : 0,
            'longest_entry' => $entries->max(fn ($entry): int => str_word_count((string) $entry->entry)),
            'mood_distribution' => $entries->whereNotNull('mood')
                ->groupBy('mood')
                ->map(fn (Collection $group): int => $group->count())
                ->sortDesc()
                ->toArray(),
            'time_distribution' => $this->timeDistribution($entries),
            'heatmap_data' => $this->heatmapData($entries),
            'top_tags' => $this->topTags($entries),
            'achievements' => $this->achievements($totalEntries, $totalWords, $streak),
        ];
    }

    /**
     * @return array<int, array{day:string,date:string,emoji:?string,label:?string,score:?int}>
     */
    public function moodData(User $user): array
    {
        $days = collect();
        $moodsByDate = $user->diaries()
            ->whereNotNull('mood')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->get()
            ->groupBy(fn ($entry) => Carbon::parse($entry->created_at)->toDateString());

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateString = $date->toDateString();
            $entriesForDay = $moodsByDate->get($dateString, collect());

            if ($entriesForDay->isEmpty()) {
                $days->push([
                    'day' => $date->format('D'),
                    'date' => $dateString,
                    'emoji' => null,
                    'label' => null,
                    'score' => null,
                ]);

                continue;
            }

            /** @var Collection<int, Mood> $moods */
            $moods = $entriesForDay->map(fn ($entry): Mood => $entry->mood);
            $dominantMood = $moods->sortByDesc(fn (Mood $mood): int => $mood->score())->first();
            $averageScore = (int) round(Mood::averageScore($moods->all()));

            $days->push([
                'day' => $date->format('D'),
                'date' => $dateString,
                'emoji' => $dominantMood?->emoji(),
                'label' => $dominantMood?->label(),
                'score' => max(-2, min(2, $averageScore)),
            ]);
        }

        return $days->contains(fn (array $day): bool => $day['score'] !== null) ? $days->all() : [];
    }

    /**
     * @param  EloquentCollection<int, Diary> $entries
     * @return array<string, int>
     */
    private function timeDistribution(EloquentCollection $entries): array
    {
        return [
            'morning' => $entries->filter(fn ($entry): bool => $entry->created_at->hour >= 5 && $entry->created_at->hour < 12)->count(),
            'afternoon' => $entries->filter(fn ($entry): bool => $entry->created_at->hour >= 12 && $entry->created_at->hour < 17)->count(),
            'evening' => $entries->filter(fn ($entry): bool => $entry->created_at->hour >= 17 && $entry->created_at->hour < 21)->count(),
            'night' => $entries->filter(fn ($entry): bool => $entry->created_at->hour >= 21 || $entry->created_at->hour < 5)->count(),
        ];
    }

    /**
     * @param  EloquentCollection<int, Diary> $entries
     * @return array<string, int>
     */
    private function heatmapData(EloquentCollection $entries): array
    {
        $heatmap = [];

        foreach ($entries as $entry) {
            $date = $entry->created_at->format('Y-m-d');
            $heatmap[$date] = ($heatmap[$date] ?? 0) + 1;
        }

        return $heatmap;
    }

    /**
     * @param  EloquentCollection<int, Diary> $entries
     * @return array<string, int>
     */
    private function topTags(EloquentCollection $entries): array
    {
        $tagCounts = [];

        foreach ($entries as $entry) {
            foreach ($entry->tags ?? [] as $tag) {
                $tagCounts[$tag->name] = ($tagCounts[$tag->name] ?? 0) + 1;
            }
        }

        arsort($tagCounts);

        return array_slice($tagCounts, 0, 10, true);
    }

    /**
     * @param  array{current:int,longest:int,todayWritten:bool} $streak
     * @return array<int, array<string, bool|string>>
     */
    private function achievements(int $totalEntries, int $totalWords, array $streak): array
    {
        return [
            ['name' => 'First Entry', 'icon' => '🌱', 'description' => 'Write your first entry', 'unlocked' => $totalEntries >= 1],
            ['name' => 'Week Warrior', 'icon' => '💪', 'description' => '7-day streak', 'unlocked' => $streak['longest'] >= 7],
            ['name' => 'Monthly Master', 'icon' => '🎯', 'description' => '30-day streak', 'unlocked' => $streak['longest'] >= 30],
            ['name' => 'Century Club', 'icon' => '💯', 'description' => '100 entries', 'unlocked' => $totalEntries >= 100],
            ['name' => 'Word Wizard', 'icon' => '📚', 'description' => '10,000 words written', 'unlocked' => $totalWords >= 10000],
            ['name' => 'Year Legend', 'icon' => '👑', 'description' => '365-day streak', 'unlocked' => $streak['longest'] >= 365],
            ['name' => 'Prolific Writer', 'icon' => '✍️', 'description' => '500 entries', 'unlocked' => $totalEntries >= 500],
            ['name' => 'Novel Writer', 'icon' => '📖', 'description' => '50,000 words', 'unlocked' => $totalWords >= 50000],
        ];
    }
}
