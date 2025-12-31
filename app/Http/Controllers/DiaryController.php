<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Diary;
use App\Enums\Privacy;
use App\Http\Requests\StoreDiaryRequest;
use Carbon\Carbon;
use Carbon\Month;
use Carbon\WeekDay;
use DateTimeInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class DiaryController extends Controller
{
    /**
     * @returns LengthAwarePaginator<int, Diary>
     */
    public function index(): LengthAwarePaginator
    {
        return request()->user()->diaries()->orderBy('created_at', 'desc')->paginate(12);
    }

    public function create(): Factory|View|Application
    {
        return view('diary.create');
    }

    public function store(StoreDiaryRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $diary = $request->user()->diaries()->create([
                'title' => $validatedData['title'] ?? null,
                'entry' => $validatedData['entry'],
                'mood' => $validatedData['mood'] ?? null,
                'privacy' => $validatedData['privacy'] ?? Privacy::Private->value,
                'is_featured' => $validatedData['is_featured'] ?? false,
                'allow_comments' => $validatedData['allow_comments'] ?? true,
            ]);

            if (! empty($validatedData['tags'])) {
                $tags = array_filter(array_map(trim(...), explode(',', (string) $validatedData['tags'])));
                $diary->syncTags($tags);
            }

            if (isset($validatedData['created_at'])) {
                $diary->created_at = $validatedData['created_at'];
                $diary->save();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Entry saved successfully',
                    'data' => $diary,
                ], 201);
            }

            return redirect()->route('home')->with('success', 'Entry saved successfully!');

        } catch (Exception $exception) {
            Log::error('Failed to save diary entry', [
                'error' => $exception->getMessage(),
                'user_id' => $request->user()->id,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save entry',
                ], 500);
            }

            return back()->withErrors(['entry' => 'Failed to save entry. Please try again.']);
        }
    }

    public function search(Request $request): Factory|View
    {
        $user = $request->user();
        $query = $user->diaries();

        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm): void {
                $q->where('entry', 'like', sprintf('%%%s%%', $searchTerm))
                    ->orWhere('title', 'like', sprintf('%%%s%%', $searchTerm));
            });
        }

        // Mood filter
        if ($request->filled('mood')) {
            $query->where('mood', $request->mood);
        }

        // Privacy filter
        if ($request->filled('privacy')) {
            $query->where('privacy', $request->privacy);
        }

        // Date range filter
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
                case 'custom':
                    if ($request->filled('date_from')) {
                        $query->whereDate('created_at', '>=', $request->date_from);
                    }

                    if ($request->filled('date_to')) {
                        $query->whereDate('created_at', '<=', $request->date_to);
                    }

                    break;
            }
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        // Has title filter
        if ($request->filled('has_title')) {
            $query->whereNotNull('title');
        }

        // Sort
        match ($request->get('sort', 'newest')) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'longest' => $query->orderByRaw('LENGTH(entry) DESC'),
            'shortest' => $query->orderByRaw('LENGTH(entry) ASC'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return view('diary.search', [
            'entries' => $query->paginate(20)->appends($request->except('page')),
            'totalResults' => $query->count(),
        ]);
    }

    public function byTag(Request $request, string $tag): Factory|View
    {
        $entries = $request->user()
            ->diaries()
            ->whereTag($tag)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('diary.tag', [
            'entries' => $entries,
            'tag' => $tag,
        ]);
    }

    public function byMood(Request $request, string $mood): Factory|View
    {
        $entries = $request->user()
            ->diaries()
            ->where('mood', $mood)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('diary.mood', [
            'entries' => $entries,
            'mood' => $mood,
        ]);
    }

    public function stats(Request $request): Factory|View
    {
        $user = $request->user();
        $entries = $user->diaries;

        // Calculate statistics
        $stats = [
            'total_entries' => $entries->count(),
            'entries_this_month' => $entries->where('created_at', '>=', now()->startOfMonth())->count(),
            'total_words' => $entries->sum(fn ($entry): int => str_word_count((string) $entry->entry)),
            'avg_words_per_entry' => $entries->count() > 0
                ? round($entries->sum(fn ($entry): int => str_word_count((string) $entry->entry)) / $entries->count())
                : 0,
            'active_days' => $entries->pluck('created_at')->map(fn ($date) => $date->format('Y-m-d'))->unique()->count(),
            'days_since_start' => $entries->min('created_at')
                ? now()->diffInDays($entries->min('created_at'))
                : 0,
            'longest_entry' => $entries->max(fn ($entry): int => str_word_count((string) $entry->entry)),

            // Mood distribution
            'mood_distribution' => $entries->whereNotNull('mood')
                ->groupBy('mood')
                ->map(fn ($group) => $group->count())
                ->sortDesc()
                ->toArray(),

            // Time distribution
            'time_distribution' => $this->getTimeDistribution($entries),

            // Heatmap data
            'heatmap_data' => $this->getHeatmapData($entries),

            // Top tags
            'top_tags' => $this->getTopTags($entries),

            // Achievements
            'achievements' => $this->getAchievements($user, $entries),
        ];

        return view('diary.stats', ['stats' => $stats]);
    }

    public function like(Request $request, Diary $diary)
    {
        // Check if entry is accessible
        if (! $this->canAccessEntry($request->user(), $diary)) {
            abort(403);
        }

        $user = $request->user();

        // Toggle like
        if ($diary->likes()->where('user_id', $user->id)->exists()) {
            $diary->likes()->detach($user->id);
            $diary->decrement('likes_count');
            $liked = false;
        } else {
            $diary->likes()->attach($user->id);
            $diary->increment('likes_count');
            $liked = true;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $diary->likes_count,
            ]);
        }

        return back();
    }

    private function updateCreatedAtIfAvailable(Request $request, Diary $diary): void
    {
        if ($request->filled('created_at')) {
            $diary->created_at = $request->created_at;
            $diary->save();
        }
    }

    private function calculateStreak($user): array
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

        // Calculate longest streak
        $checkDate = $entries->first();
        foreach ($entries as $entry) {
            if ($entry->isSameDay($checkDate) || $entry->isSameDay($checkDate->subDay())) {
                $tempStreak++;
                $longestStreak = max($longestStreak, $tempStreak);
                $checkDate = $entry->subDay();
            } else {
                $tempStreak = 1;
                $checkDate = $entry->subDay();
            }
        }

        return [
            'current' => $currentStreak,
            'longest' => max($longestStreak, $currentStreak),
            'todayWritten' => $todayWritten,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function getTimeDistribution($entries): array
    {
        return [
            'morning' => $entries->filter(fn ($e): bool => $e->created_at->hour >= 5 && $e->created_at->hour < 12)->count(),
            'afternoon' => $entries->filter(fn ($e): bool => $e->created_at->hour >= 12 && $e->created_at->hour < 17)->count(),
            'evening' => $entries->filter(fn ($e): bool => $e->created_at->hour >= 17 && $e->created_at->hour < 21)->count(),
            'night' => $entries->filter(fn ($e): bool => $e->created_at->hour >= 21 || $e->created_at->hour < 5)->count(),
        ];
    }

    /**
     * @return int[]
     */
    private function getHeatmapData($entries): array
    {
        $heatmap = [];
        foreach ($entries as $entry) {
            $date = $entry->created_at->format('Y-m-d');
            $heatmap[$date] = isset($heatmap[$date]) ? $heatmap[$date] + 1 : 1;
        }

        return $heatmap;
    }

    private function getTopTags($entries): array
    {
        $tagCounts = [];
        foreach ($entries as $entry) {
            if (! empty($entry->tags)) {
                foreach ($entry->tags as $tag) {
                    $tagCounts[$tag] = isset($tagCounts[$tag]) ? $tagCounts[$tag] + 1 : 1;
                }
            }
        }

        arsort($tagCounts);

        return array_slice($tagCounts, 0, 10, true);
    }

    /**
     * @return array<int, array<string, bool|string>>
     */
    private function getAchievements($user, $entries): array
    {
        $totalEntries = $entries->count();
        $totalWords = $entries->sum(fn ($entry): int => str_word_count((string) $entry->entry));
        $streak = $this->calculateStreak($user);

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

    private function canAccessEntry($user, Diary $diary)
    {
        if ($diary->user_id === $user->id) {
            return true;
        }

        return match ($diary->privacy) {
            'public' => true,
            'followers' => $diary->user->followers()->where('follower_id', $user->id)->exists(),
            default => false,
        };
    }
}
