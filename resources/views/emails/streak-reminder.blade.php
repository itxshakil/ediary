@component('mail::message')
# Don't break your streak, {{ $user->username }}!

@if($streak)
You're on a **{{ $streak }}-day** writing streak. Write today to keep it going.
@else
You haven't written today yet. A couple of lines is all it takes to keep the habit alive.
@endif

@component('mail::button', ['url' => url('/home')])
Write today's entry
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
