<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Diary\StoreDiaryAction;
use App\Diary;
use App\Enums\Privacy;
use App\Http\Requests\StoreDiaryRequest;
use App\Services\Diary\DiaryAnalyticsService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final class DiaryController extends Controller
{
    public function __construct(
        private readonly StoreDiaryAction $storeDiary,
        private readonly DiaryAnalyticsService $analytics,
    ) {}

    /**
     * @return LengthAwarePaginator<int, Diary>|Factory|View
     */
    public function index(Request $request): LengthAwarePaginator|Factory|View
    {
        $entries = $request->user()->diaries()->latest()->with('tags')->paginate(12);

        if ($request->expectsJson()) {
            return $entries;
        }

        return view('diary.index', ['entries' => $entries]);
    }

    public function create(): Factory|View|Application
    {
        return view('diary.create');
    }

    public function store(StoreDiaryRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $diary = $this->storeDiary->execute($request->user(), $request->validated());

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

            return back()->withErrors(['entry' => 'Failed to save entry. Please try again.'])->withInput();
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

        /** @var string $view */
        $view = 'diary.tag';

        return view($view, [
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

        /** @var string $view */
        $view = 'diary.mood';

        return view($view, [
            'entries' => $entries,
            'mood' => $mood,
        ]);
    }

    public function stats(Request $request): Factory|View
    {
        $user = $request->user();
        $entries = $user->diaries()->with('tags')->get();
        $stats = $this->analytics->stats($user, $entries);

        /** @var string $view */
        $view = 'diary.stats';

        return view($view, ['stats' => $stats]);
    }

    public function like(Request $request, Diary $diary): JsonResponse|RedirectResponse
    {
        if (! $this->canAccessEntry($request->user(), $diary)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $user = $request->user();

        if ($diary->likes()->where('user_id', $user->id)->exists()) {
            $diary->likes()->where('user_id', $user->id)->delete();
            $diary->decrement('likes_count');
            $liked = false;
        } else {
            $diary->likes()->create(['user_id' => $user->id]);
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

    private function canAccessEntry($user, Diary $diary): bool
    {
        if ($diary->user_id === $user->id) {
            return true;
        }

        return match ($diary->privacy) {
            Privacy::Public => true,
            Privacy::Followers => $diary->owner->profile->follower()->where('user_id', $user->id)->exists(),
            default => false,
        };
    }
}
