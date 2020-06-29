<?php

namespace App\Listeners;

use App\Events\PasswordChanged;
use App\Mail\PasswordChanged as MailPasswordChanged;
use Illuminate\Support\Facades\Mail;

class SendPasswordChangedNotification
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
     * @param  PasswordChanged $event
     * @return void
     */
    public function handle(PasswordChanged $event)
    {
        Mail::to($event->user->email)->send(new MailPasswordChanged($event->user));
    }
}
