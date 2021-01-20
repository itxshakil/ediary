<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiaryController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $diaries = auth()->user()->diaries()->latest()->paginate(12);

        return $diaries;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
