<?php

namespace App\Http\Controllers\Api;

use App\Diary;
use Illuminate\Http\Request;

class DiaryController
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return auth()->user()->diaries()->latest()->paginate(12);
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

        $this->addCreatedAtIfAvailable($request, $diary);

        return $diary;
    }

    /**
     * @param Request $request
     * @param $diary
     */
    protected function addCreatedAtIfAvailable(Request $request, $diary): void
    {
        if ($request->filled('created_at')) {
            $diary->created_at = $request->created_at;
            $diary->save();
        }
    }
}
