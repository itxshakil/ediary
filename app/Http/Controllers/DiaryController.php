<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
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
     * @return Response
     */
    public function store(Request $request):Diary
    {
        $validatedData = $request->validate(['entry' => ['required', 'string']]);

        $diary = auth()->user()->diaries()->create($validatedData);

        if ($request->filled('created_at')) {
            $diary->created_at = $request->created_at;
            $diary->save();
        }

        return $diary;
    }
}
