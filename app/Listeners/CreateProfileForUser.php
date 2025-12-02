<?php

declare(strict_types=1);

namespace App\Listeners;

use App\User;
use Illuminate\Auth\Events\Registered;

final class CreateProfileForUser
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        /**
         * @var User $user
         */
        $user = $event->user;
        $user->profile()->create([
            'name' => $user->username,
        ]);
    }
}
