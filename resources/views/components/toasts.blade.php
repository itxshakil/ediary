@php
    $messages = collect([
        ['type' => 'success', 'message' => session('success')],
        ['type' => 'success', 'message' => session('flash')],
        ['type' => 'info', 'message' => session('status')],
        ['type' => 'error', 'message' => session('error')],
    ])->filter(fn (array $toast): bool => filled($toast['message']));
@endphp

{{-- One feedback channel: server messages render here, and window.toast() adds more from the same template. --}}
<section id="toasts" class="toast-region" aria-label="Notifications">
    @foreach ($messages as $toast)
        <x-toast :type="$toast['type']" :message="$toast['message']" />
    @endforeach
</section>

<template id="toast-template">
    <x-toast type="info" message="" />
</template>
