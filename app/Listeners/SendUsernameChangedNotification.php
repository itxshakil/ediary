<?php

namespace App\Listeners;

use App\Events\UsernameChanged;
use App\Mail\UsernameChanged as MailUsernameChanged;
use Illuminate\Support\Facades\Mail;

class SendUsernameChangedNotification
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
     * @param  UsernameChanged $event
     * @return void
     */
    public function handle(UsernameChanged $event)
    {
        Mail::to($event->user->email)->send(new MailUsernameChanged($event->user));
    }
}
