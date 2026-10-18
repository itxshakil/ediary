<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Diary\StoreDiaryAction;
use App\Http\Requests\StoreDiaryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

final class SyncController extends Controller
{
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

        } catch (Throwable $throwable) {
            report($throwable);

            Log::error('Failed to save diary entry', [
                'error' => $throwable->getMessage(),
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
}
