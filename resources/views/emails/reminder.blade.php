<x-mail::message>
@switch($kind)
@case(\App\Enums\ReminderKind::Streak)
# Keep it going

@if ($streak && $streak > 1)
You're on a **{{ $streak }}-day** writing streak. A couple of lines tonight keeps it alive.
@else
You wrote yesterday. A couple of lines tonight starts a streak.
@endif
@break
@case(\App\Enums\ReminderKind::FirstEntry)
# Your diary is waiting

Your first entry can be as short as one line, and it stays private unless you choose to share it.
@break
@default
# A few lines tonight?

It's been a little while. No pressure: even one sentence about today counts.
@endswitch

**Tonight's prompt:** {{ $prompt }}

<x-mail::button :url="$writeUrl">
Write tonight's entry
</x-mail::button>

Ediary

<x-slot:subcopy>
You're getting this because evening reminders are on for your Ediary account. [Turn off reminders]({{ $unsubscribeUrl }}) or change them in Settings.
</x-slot:subcopy>
</x-mail::message>
