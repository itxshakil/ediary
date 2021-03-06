<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator     
     */
    public function index()
    {
        return auth()->user()->diaries()->orderBy('created_at', 'desc')->paginate(12);

        return view('diary.index', compact('diaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Factory|View|Application
    {
        return view('diary.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Diary
     */
    public function store(Request $request):Diary
    {
        $validatedData = $request->validate(['entry' => ['required', 'string']]);

        $diary = auth()->user()->diaries()->create($validatedData);

        $this->updateCreatedAtIfAvailable($request, $diary);

        return $diary;
    }

    /**
     * @param Request $request
     * @param $diary
     */
    protected function updateCreatedAtIfAvailable(Request $request, $diary): void
    {
        if ($request->filled('created_at')) {
            $diary->created_at = $request->created_at;
            $diary->save();
        }
    }
}
