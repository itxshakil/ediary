<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use DateTimeZone;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class ReminderController
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reminders_enabled' => ['nullable', 'boolean'],
            'timezone' => ['required', 'string', Rule::in(DateTimeZone::listIdentifiers(DateTimeZone::ALL_WITH_BC))],
        ]);

        $request->user()->update([
            'reminders_enabled' => $request->boolean('reminders_enabled'),
            'timezone' => $validated['timezone'],
        ]);

        return redirect('/settings')->with('success', 'Reminder settings saved.');
    }

    /**
     * Reached from the link in a reminder: asks before acting, so link scanners can't unsubscribe anyone.
     */
    public function confirmUnsubscribe(User $user): View
    {
        return view('reminders.unsubscribe', ['user' => $user, 'done' => false]);
    }

    /**
     * The confirm button, and mail clients' one-click unsubscribe (RFC 8058), both post here.
     */
    public function unsubscribe(User $user): View
    {
        $user->update(['reminders_enabled' => false]);

        return view('reminders.unsubscribe', ['user' => $user, 'done' => true]);
    }
}
