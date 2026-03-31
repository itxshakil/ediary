<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class FollowController
{
    public function store(Request $request, User $user): Response
    {
        $user->profile->follower()->toggle($request->user()->id);

        return response()->noContent();
    }
}
