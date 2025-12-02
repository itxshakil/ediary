<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;

final class FollowController
{
    public function store(User $user)
    {
        return $user->profile->follower()->toggle(auth()->id());
    }
}
