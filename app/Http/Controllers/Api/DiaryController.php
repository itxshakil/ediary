<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class DiaryController
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
