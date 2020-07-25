<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diaries = auth()->user()->diaries()->latest()->paginate(12);

        return $diaries;

        return view('diary.index', compact('diaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('diary.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
