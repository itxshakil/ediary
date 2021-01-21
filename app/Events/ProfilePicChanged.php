<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProfilePicChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public mixed $path;

    /**
     * Create a new event instance.
     *
     * @param mixed $path
     */
    public function __construct(mixed $path)
    {
        $this->path = $path;
    }
}
