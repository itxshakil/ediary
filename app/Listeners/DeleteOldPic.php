<?php

namespace App\Listeners;

use App\Events\PasswordChanged;
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
        //
    }

    /**
     * Handle the event.
     *
     * @param  PasswordChanged  $event
     * @return void
     */
    public function handle(PasswordChanged $event)
    {
        Storage::disk('s3')->delete($event->path);
    }
}
