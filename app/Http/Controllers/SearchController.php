<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $query = $request->query('q');
        $users = User::search($query)
                    ->with('profile')
                ->paginate(12);

        return view('search.show', compact('users'));
    }
}
