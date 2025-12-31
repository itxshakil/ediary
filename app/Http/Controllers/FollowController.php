<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Response;

final class FollowController
{
    public function store(User $user): Response
    {
        $user->profile->follower()->toggle(auth()->id());

        return response()->noContent();
    }
}
