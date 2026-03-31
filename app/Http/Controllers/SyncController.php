<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Diary\StoreDiaryAction;
use App\Http\Requests\StoreSyncedDiaryRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

final class SyncController extends Controller
{
    public function store(StoreSyncedDiaryRequest $request, StoreDiaryAction $action): JsonResponse|RedirectResponse
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

        } catch (Exception|Throwable $exception) {
            report($exception);

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

    /**
     * Get pending sync status.
     */
    public function syncStatus(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'pending_count' => 0, // Implement your logic here
            'last_sync' => now(),
        ]);
    }
}
