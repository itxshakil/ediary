@component('mail::message')
# Your password was changed

## The password for your appediary account {{$user->username}} was changed. 

If you didn't changed password, you should [Reset your password](/password/reset "Reset password").


Thanks,<br>
{{ config('app.name') }}
@endcomponent
