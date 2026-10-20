@php
    $events = app(\App\Support\Analytics::class)->pull();
@endphp

@if ($events !== [])
    {{-- Funnel events raised on the server (signup, login, entries); see App\Support\Analytics. --}}
    <script>
        window.dataLayer = window.dataLayer || [];
        @foreach ($events as $event)
            window.dataLayer.push(@json($event));
        @endforeach
    </script>
@endif
