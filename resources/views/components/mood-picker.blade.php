@props(['selected' => null, 'legend' => 'How are you feeling?'])

{{-- Radio chips: native keyboard support and form submission; mood-picker.js lets a picked mood be cleared. --}}
<fieldset data-mood-picker {{ $attributes }}>
    <legend class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $legend }} <span class="font-normal text-gray-400">(optional)</span>
    </legend>
    <div class="flex flex-wrap gap-2">
        @foreach (\App\Enums\Mood::cases() as $mood)
            <label class="chip min-h-10">
                <input
                    type="radio"
                    name="mood"
                    value="{{ $mood->value }}"
                    class="sr-only"
                    @checked($selected === $mood->value)
                />
                <span aria-hidden="true">{{ $mood->emoji() }}</span>
                {{ $mood->label() }}
            </label>
        @endforeach
    </div>
</fieldset>
