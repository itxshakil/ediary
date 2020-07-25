<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SearchController
{
    public function show(Request $request)
    {
        $users = User::search($request->query('q'))
            ->with('profile')
            ->paginate(12);

        return view('search.show', compact('users'));
    }
}
