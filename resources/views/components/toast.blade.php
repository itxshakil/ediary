@props(['type' => 'info', 'title' => null, 'message' => ''])

<div class="toast" data-toast data-toast-type="{{ $type }}" role="{{ $type === 'error' ? 'alert' : 'status' }}">
    <span class="toast__icon" aria-hidden="true">
        <svg data-icon="success" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <svg data-icon="error" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5m0 3h.01" />
        </svg>
        <svg data-icon="warning" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 3h.01M10.3 3.9L2.4 17.6A2 2 0 004.1 20.6h15.8a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
        </svg>
        <svg data-icon="info" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01" />
        </svg>
    </span>
    <div class="min-w-0 flex-1">
        <p class="toast__title" data-toast-title @if (! $title) hidden @endif>{{ $title }}</p>
        <p class="toast__message" data-toast-message>{{ $message }}</p>
    </div>
    <button type="button" class="toast__close" data-toast-close aria-label="Dismiss notification">
        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
