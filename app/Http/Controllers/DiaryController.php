<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function store(Request $request): Diary
    {
        $validatedData = $request->validate(['entry' => ['required', 'string']]);

        /**
         * @var Diary $diary
         */
        $diary = request()->user()->diaries()->create($validatedData);

        $this->updateCreatedAtIfAvailable($request, $diary);

        return $diary;
    }

    private function updateCreatedAtIfAvailable(Request $request, Diary $diary): void
    {
        if ($request->filled('created_at')) {
            $diary->created_at = $request->created_at;
            $diary->save();
        }
    }
}
