@props(['entry', 'showOwner' => false])

@php
    $words = str_word_count($entry->entry);
    $minutes = max(1, (int) ceil($words / 200));
    $isLong = mb_strlen($entry->entry) > 280 || mb_substr_count($entry->entry, "\n") > 2;
@endphp

<article @class(['diary-card', 'diary-card--' . ($entry->mood?->category() ?? 'none')])>
    <div class="diary-card-inner">
        {{-- Calendar-style date, localised to the reader's timezone by relative-dates.js --}}
        <time
            class="diary-card-date"
            datetime="{{ $entry->created_at->toISOString() }}"
            data-time="{{ $entry->created_at->toISOString() }}"
        >
            <span class="diary-card-date-day" data-date-part="day">{{ $entry->created_at->format('j') }}</span>
            <span class="diary-card-date-month" data-date-part="month">{{ $entry->created_at->format('M') }}</span>
            <span class="diary-card-date-weekday" data-date-part="weekday">{{ $entry->created_at->format('D') }}</span>
        </time>

        <div class="diary-card-body">
            <header class="diary-card-header">
                @if ($showOwner)
                    <a href="{{ route('profile.show', $entry->owner->username) }}" class="diary-card-owner">
                        <img src="{{ $entry->owner->profile->image }}" alt="" class="diary-card-owner-avatar" />
                        {{ $entry->owner->profile->name ?? $entry->owner->username }}
                    </a>
                @endif

                <time
                    class="diary-card-when js-date"
                    datetime="{{ $entry->created_at->toISOString() }}"
                    data-time="{{ $entry->created_at->toISOString() }}"
                >{{ $entry->created_at->diffForHumans() }}</time>

                <div class="diary-card-badges">
                    @if ($entry->mood)
                        @if ($showOwner)
                            <span class="diary-card-mood">
                                <span aria-hidden="true">{{ $entry->mood->emoji() }}</span>
                                {{ $entry->mood->label() }}
                            </span>
                        @else
                            <a
                                href="{{ route('diary.mood', $entry->mood) }}"
                                class="diary-card-mood"
                                title="All {{ strtolower($entry->mood->label()) }} entries"
                            >
                                <span aria-hidden="true">{{ $entry->mood->emoji() }}</span>
                                {{ $entry->mood->label() }}
                            </a>
                        @endif
                    @endif
                    @unless ($showOwner)
                        <span class="diary-card-privacy" title="Visible to: {{ $entry->privacy->label() }}">
                            <span aria-hidden="true">{{ $entry->privacy->emoji() }}</span>
                            <span class="diary-card-privacy-label">{{ Str::before($entry->privacy->label(), ' (') }}</span>
                        </span>
                    @endunless
                </div>
            </header>

            @if ($entry->title)
                <h3 class="diary-card-title">{{ $entry->title }}</h3>
            @endif

            @if ($isLong)
                {{-- Native disclosure: no JS, animates open where ::details-content is supported --}}
                <details class="diary-card-details">
                    <summary>
                        <p class="diary-card-text diary-card-excerpt">{{ $entry->entry }}</p>
                        <span class="diary-card-toggle" aria-hidden="true"></span>
                        <span class="sr-only">Show the full entry</span>
                    </summary>
                    <p class="diary-card-text">{{ $entry->entry }}</p>
                </details>
            @else
                <p class="diary-card-text">{{ $entry->entry }}</p>
            @endif

            <footer class="diary-card-footer">
                @if ($entry->tags->isNotEmpty())
                    <div class="diary-card-tags">
                        @foreach ($entry->tags as $tag)
                            @if ($showOwner)
                                <span class="chip-tag">#{{ $tag->name }}</span>
                            @else
                                <a href="{{ route('diary.tag', $tag->name) }}" class="chip-tag">#{{ $tag->name }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif

                <span class="diary-card-reading">
                    {{ trans_choice('{1} 1 word|[0,*] :count words', $words, ['count' => number_format($words)]) }} · {{ $minutes }} min
                    read
                </span>

                @if (! $showOwner && in_array($entry->privacy->value, ['public', 'unlisted'], true))
                    <a href="{{ route('diary.public', $entry) }}" class="diary-card-share-link">Public page &rarr;</a>
                @endif
            </footer>
        </div>
    </div>
</article>
