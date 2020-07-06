@component('mail::message')
# Your password was changed

## The password for your appediary account {{$user->username}} was changed.

If you didn't change password, you should [Reset your password]({{url('/password/reset')}} "Reset password") now to secure your account.


Thanks,<br>
{{ config('app.name') }}
@endcomponent