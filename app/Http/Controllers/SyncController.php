<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Diary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class SyncController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'entry' => ['required', 'string'],
            'created_at' => ['nullable', 'date'],
        ]);

        try {
            /** @var Diary $diary */
            $diary = $request->user()->diaries()->create([
                'entry' => $validatedData['entry'],
            ]);

            // If created_at is provided (from offline sync), update it
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

    /**
     * Get pending sync status.
     */
    public function syncStatus(Request $request)
    {
        return response()->json([
            'success' => true,
            'pending_count' => 0, // Implement your logic here
            'last_sync' => now(),
        ]);
    }
}
