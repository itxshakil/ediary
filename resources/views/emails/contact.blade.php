@component('mail::message')
# Contact Us Form By {{$name}}


@component('mail::panel')
Name : {{$name}} <br>
Email : {{$email}} <br>
Message : {{$message}}<br>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent