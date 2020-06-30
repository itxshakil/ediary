<?php

namespace App\Listeners;

use App\Events\ProfilePicChanged;
use Illuminate\Support\Facades\Storage;

class DeleteOldPic
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
     * @param  ProfilePicChanged $event
     * @return void
     */
    public function handle(ProfilePicChanged $event)
    {
        Storage::disk('s3')->delete($event->path);
    }
}
