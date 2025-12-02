<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UsernameChanged;
use App\Mail\UsernameChanged as MailUsernameChanged;
use Illuminate\Support\Facades\Mail;

final class SendUsernameChangedNotification
{
    /**
     * Handle the event.
     */
    public function handle(UsernameChanged $event): void
    {
        Mail::to($event->user->email)->send(new MailUsernameChanged($event->user));
    }
}
