@props(['padding' => 'p-6'])

<div {{ $attributes->class(['rounded-2xl border border-gray-200 bg-white shadow-card dark:border-gray-700 dark:bg-gray-800', $padding]) }}>
    {{ $slot }}
</div>
