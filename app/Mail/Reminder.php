<?php

declare(strict_types=1);

namespace App\Mail;

use App\Enums\ReminderKind;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

/**
 * An evening nudge to write. It never includes entry text: the inbox is not private.
 */
final class Reminder extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user, public ReminderKind $kind, public ?int $streak = null) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->kind->subject($this->streak));
    }

    public function content(): Content
    {
        $prompts = config('prompts.daily');

        return new Content(markdown: 'emails.reminder', with: [
            'kind' => $this->kind,
            'streak' => $this->streak,
            'prompt' => $prompts[now($this->user->localTimezone())->dayOfYear % count($prompts)],
            'writeUrl' => route('diary.create', ['utm_source' => 'email', 'utm_medium' => 'reminder', 'utm_campaign' => $this->kind->value]),
            'unsubscribeUrl' => $this->unsubscribeUrl(),
        ]);
    }

    /**
     * RFC 8058 one-click unsubscribe, which Gmail and Yahoo expect from bulk senders.
     */
    public function headers(): Headers
    {
        return new Headers(text: [
            'List-Unsubscribe' => "<{$this->unsubscribeUrl()}>",
            'List-Unsubscribe-Post' => 'List-Unsubscribe=One-Click',
        ]);
    }

    private function unsubscribeUrl(): string
    {
        return URL::signedRoute('reminders.unsubscribe', $this->user);
    }
}
