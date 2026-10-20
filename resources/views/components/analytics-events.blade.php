@php
    $events = app(\App\Support\Analytics::class)->pull();
@endphp

@if ($events !== [])
    {{-- Funnel events raised on the server (signup, login, entries); see App\Support\Analytics. --}}
    <script>
        @foreach ($events as $event)
            gtag('event', @json($event['name']), @json((object) $event['params']));
        @endforeach
    </script>
@endif
