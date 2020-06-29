<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProfilePicChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $path;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }
}
