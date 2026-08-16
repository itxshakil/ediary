<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Diary\ExportDiariesAction;
use App\Actions\Diary\StoreDiaryAction;
use App\Diary;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreDiaryRequest;
use App\Services\Diary\DiaryAnalyticsService;
use App\Services\Diary\DiaryExploreService;
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
use Throwable;

final class DiaryController extends Controller
{
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

    public function store(StoreDiaryRequest $request, StoreDiaryAction $action): JsonResponse|RedirectResponse
    {
        try {
            $diary = $action->execute($request->user(), $request->validated());

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
        } catch (Throwable $e) {
            report($e);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
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
        match ($request->input('sort', 'newest')) {
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

        $view = 'diary.mood';

        return view($view, [
            'entries' => $entries,
            'mood' => $mood,
        ]);
    }

    public function stats(Request $request, DiaryAnalyticsService $service): Factory|View
    {
        $user = $request->user();
        $entries = $user->diaries()->with('tags')->get();
        $stats = $service->stats($user, $entries);

        $view = 'diary.stats';

        return view($view, ['stats' => $stats]);
    }

    public function like(Request $request, Diary $diary): JsonResponse|RedirectResponse
    {
        if (! $diary->isVisibleTo($request->user())) {
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

    public function comment(StoreCommentRequest $request, Diary $diary): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        if (! $diary->isVisibleTo($user) || ! $diary->allow_comments) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $comment = $diary->comments()->create([
            'user_id' => $user->id,
            'comment' => $request->validated('comment'),
        ]);
        $diary->increment('comments_count');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user.profile'),
            ]);
        }

        return back()->with('success', 'Comment posted.');
    }

    public function export(Request $request, ExportDiariesAction $action): Response
    {
        $entries = $action->toArray($request->user());
        $format = $request->query('format', 'json');

        if ($format === 'csv') {
            return $this->exportAsCsv($entries);
        }

        return response(json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="diary-export.json"',
        ]);
    }

    public function showPublic(Request $request, Diary $diary): Factory|View
    {
        if (! $diary->isVisibleTo($request->user())) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $diary->increment('views_count');

        return view('diary.public', [
            'entry' => $diary->load(['owner.profile', 'tags', 'likes', 'comments.user.profile']),
        ]);
    }

    public function explore(DiaryExploreService $service): Factory|View
    {
        return view('diary.explore', [
            'entries' => $service->feed(),
        ]);
    }

    /**
     * @param array<int, array<string, mixed>> $entries
     */
    private function exportAsCsv(array $entries): Response
    {
        $columns = ['title', 'entry', 'mood', 'privacy', 'tags', 'created_at'];

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, $columns);

        foreach ($entries as $entry) {
            $entry['tags'] = implode('|', $entry['tags']);
            fputcsv($handle, array_map(static fn ($value): string => (string) $value, $entry));
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, Response::HTTP_OK, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="diary-export.csv"',
        ]);
    }
}
