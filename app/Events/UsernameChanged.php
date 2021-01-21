<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UsernameChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    /**
     * Create a new event instance.
     *
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
