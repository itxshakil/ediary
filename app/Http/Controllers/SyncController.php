<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Diary\StoreDiaryAction;
use App\Http\Requests\StoreSyncedDiaryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

final class SyncController extends Controller
{
    public function store(StoreSyncedDiaryRequest $request, StoreDiaryAction $action): JsonResponse|RedirectResponse
    {
        $diary = $action->execute($request->user(), $request->validated());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Entry saved successfully',
                'data' => $diary,
            ], 201);
        }

        return redirect()->route('home')->with('success', 'Entry saved successfully!');
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
