<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class DiaryController extends Controller
{
    public function index()
    {
        return auth()->user()->diaries()->orderBy('created_at', 'desc')->paginate(12);
    }

    public function create(): Factory|View|Application
    {
        return view('diary.create');
    }

    public function store(Request $request): Diary
    {
        $validatedData = $request->validate(['entry' => ['required', 'string']]);

        $diary = auth()->user()->diaries()->create($validatedData);

        $this->updateCreatedAtIfAvailable($request, $diary);

        return $diary;
    }

    protected function updateCreatedAtIfAvailable(Request $request, $diary): void
    {
        if ($request->filled('created_at')) {
            $diary->created_at = $request->created_at;
            $diary->save();
        }
    }
}
