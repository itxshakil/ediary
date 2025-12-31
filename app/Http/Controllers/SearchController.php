<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class SearchController
{
    public function show(Request $request): Factory|View|Application
    {
        $users = User::query()->when($request->filled('q'), function (Builder $query) use ($request) {
            /** @var Builder<User> $query */
            $query->search($request->query('q'));
        }, function (Builder $query) {
            $query->inRandomOrder()->take(10);
        })->with('profile')
            ->withCount('diaries')
            ->paginate(12);

        return view('search.show', ['users' => $users]);
    }
}
