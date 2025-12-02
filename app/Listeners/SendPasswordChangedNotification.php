<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PasswordChanged;
use App\Mail\PasswordChanged as MailPasswordChanged;
use Illuminate\Support\Facades\Mail;

final class SendPasswordChangedNotification
{
    /**
     * Handle the event.
     */
    public function handle(PasswordChanged $event): void
    {
        Mail::to($event->user->email)->send(new MailPasswordChanged($event->user));
    }
}
