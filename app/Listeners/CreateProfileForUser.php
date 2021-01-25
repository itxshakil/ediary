<?php

namespace App\Listeners;

class CreateProfileForUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        $event->user->profile()->create([
            'name' => $event->user->username,
        ]);
    }
}
