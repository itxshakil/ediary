<?php

declare(strict_types=1);

namespace App\Services\Diary;

use App\Diary;
use App\Enums\Mood;
use App\User;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

final class DiaryAnalyticsService
{
    /**
     * Consecutive days with at least one entry, counted in the writer's own timezone. The current
     * streak stays alive until the end of today, so it only breaks once a whole day is missed.
     *
     * @return array{current:int,longest:int,todayWritten:bool}
     */
    public function streak(User $user): array
    {
        $timezone = $user->localTimezone();
        $days = $user->diaries()
            ->pluck('created_at')
            ->map(fn (DateTimeInterface|string $at): string => Carbon::parse($at)->setTimezone($timezone)->toDateString())
            ->unique()
            ->sort()
            ->values();

        if ($days->isEmpty()) {
            return ['current' => 0, 'longest' => 0, 'todayWritten' => false];
        }

        $longest = 0;
        $run = 0;
        $previous = null;
        foreach ($days as $day) {
            $run = $previous !== null && Carbon::parse($previous)->addDay()->toDateString() === $day ? $run + 1 : 1;
            $longest = max($longest, $run);
            $previous = $day;
        }

        $today = now($timezone)->toDateString();
        $yesterday = now($timezone)->subDay()->toDateString();
        $current = in_array($days->last(), [$today, $yesterday], strict: true) ? $run : 0;

        return [
            'current' => $current,
            'longest' => $longest,
            'todayWritten' => $days->last() === $today,
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
            'days_since_start' => $entries->isNotEmpty()
                ? (int) $entries->min('created_at')->copy()->startOfDay()->diffInDays(today())
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
            ->groupBy(fn ($entry): string => Carbon::parse($entry->created_at)->toDateString());

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

        return array_slice($tagCounts, 0, 10, preserve_keys: true);
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
