<?php

declare(strict_types=1);

namespace App\Http\Controllers\Diary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return view('search.index', [
            'entries' => $user->diaries()->search($request->input('q'))->latest()->with('tags')->paginate(6),
        ]);
    }
}
