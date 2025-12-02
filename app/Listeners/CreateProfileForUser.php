<?php

declare(strict_types=1);

namespace App\Listeners;

final class CreateProfileForUser
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->profile()->create([
            'name' => $event->user->username,
        ]);
    }
}
