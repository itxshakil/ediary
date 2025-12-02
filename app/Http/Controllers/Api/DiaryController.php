<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Diary;
use Illuminate\Http\Request;

final class DiaryController
{
    public function index()
    {
        return auth()->user()->diaries()->latest()->paginate(12);
    }

    public function store(Request $request): Diary
    {
        $validatedData = $request->validate(['entry' => ['required', 'string']]);

        $diary = auth()->user()->diaries()->create($validatedData);

        $this->addCreatedAtIfAvailable($request, $diary);

        return $diary;
    }

    private function addCreatedAtIfAvailable(Request $request, $diary): void
    {
        if ($request->filled('created_at')) {
            $diary->created_at = $request->created_at;
            $diary->save();
        }
    }
}
