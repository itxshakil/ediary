{{-- Fields shared by the new-entry and edit pages. $entry is the entry being edited, or null. --}}
@php($entry ??= null)
@php($prefillTitle ??= null)

<div class="mb-5">
    <x-form.label for="title"> Title <span class="font-normal text-gray-400">(optional)</span></x-form.label>
    <input
        type="text"
        id="title"
        name="title"
        value="{{ old('title', $entry?->title ?? $prefillTitle) }}"
        placeholder="Give your entry a title…"
        class="field"
    />
    <x-form.error name="title" />
</div>

<div class="mb-5">
    <x-form.label for="entry">Entry <span class="text-red-400">*</span></x-form.label>
    <textarea
        id="entry"
        name="entry"
        class="field notebook"
        placeholder="It was an awesome day today…"
        required
        autofocus
    >{{ old('entry', $entry?->entry) }}</textarea>
    <x-dictate-button target="entry" class="mt-2" />
    <x-form.error name="entry" />
</div>

<div class="mb-5">
    <x-mood-picker :selected="old('mood', $entry?->mood?->value)" legend="Mood" />
    <x-form.error name="mood" />
</div>

<div class="mb-5">
    <x-form.label for="tags">
        Tags <span class="font-normal text-gray-400">(optional, comma-separated)</span></x-form.label>
    <input
        type="text"
        id="tags"
        name="tags"
        value="{{ old('tags', $entry?->tag_list) }}"
        placeholder="work, gratitude, travel…"
        class="field"
    />
    <x-form.error name="tags" />
</div>

<div class="mb-6">
    <x-form.label for="privacy">Privacy</x-form.label>
    <select id="privacy" name="privacy" class="field">
        @foreach (\App\Enums\Privacy::cases() as $privacy)
            <option
                value="{{ $privacy->value }}"
                @selected(old('privacy', $entry?->privacy->value ?? 'private') === $privacy->value)
            >
                {{ $privacy->emoji() }} {{ $privacy->label() }}
            </option>
        @endforeach
    </select>
    <x-form.error name="privacy" />
</div>
