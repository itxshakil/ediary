<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class SearchController
{
    public function show(Request $request): Factory|View|Application
    {
        $users = User::search($request->query('q'))
            ->with('profile')
            ->paginate(12);

        return view('search.show', ['users' => $users]);
    }
}
