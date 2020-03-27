@component('mail::message')
# Contact Us Form


@component('mail::panel')
Name : {{$name}} <br>
Email : {{$email}} <br>
Message : {{$message}}<br>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent