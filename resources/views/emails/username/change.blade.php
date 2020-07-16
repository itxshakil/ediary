@component('mail::message')
# Your username was changed

## The username for your appediary account was changed to *{{$user->username}}*.

If you didn't change username, you should [Contact Us]({{url('/contact')}} "Contact Us") now to secure your account.


Thanks,<br>
{{ config('app.name') }}
@endcomponent