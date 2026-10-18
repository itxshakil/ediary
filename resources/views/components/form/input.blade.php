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
    {{
        $attributes->merge([
            'class' => 'field',
        ])
    }}
/>
