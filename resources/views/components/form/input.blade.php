@props([
    'id',
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
])

<input
    id="{{ $id }}"
    name="{{ $name }}"
    type="{{ $type }}"
    value="{{ old($name, $value) }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge([
        'class' => '
            w-full px-4 py-2 rounded-xl
            bg-white dark:bg-gray-800
            border border-gray-200 dark:border-gray-700
            text-gray-900 dark:text-gray-100
            placeholder-gray-400 dark:placeholder-gray-500
            focus:outline-none
            focus:ring-4 focus:ring-blue-500/15
            focus:border-blue-500
            transition duration-150 ease-in-out
        '
    ]) }}
/>
