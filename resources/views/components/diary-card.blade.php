@props(['entry', 'showOwner' => false])

<article class="diary-card">
    {{-- Header --}}
    <div class="diary-card-header">
        @if($showOwner)
            <a href="{{ route('profile.show', $entry->owner->username) }}" class="diary-card-owner">
                <img
                    src="{{ $entry->owner->profile->image }}"
                    alt="{{ $entry->owner->username }}"
                    class="diary-card-owner-avatar"
                />
                <span>{{ $entry->owner->profile->name ?? $entry->owner->username }}</span>
            </a>
        @endif
        <time class="diary-card-date" data-time="{{ $entry->created_at->toISOString() }}">
            <span class="js-date">{{ $entry->created_at->diffForHumans() }}</span>
        </time>
        <div class="diary-card-meta">
            @if($entry->mood)
                <span title="{{ $entry->mood->label() }}">{{ $entry->mood->emoji() }}</span>
            @endif
            <span title="{{ $entry->privacy->label() }}">{{ $entry->privacy->emoji() }}</span>
        </div>
    </div>

    @if($entry->title)
        <h3 class="diary-card-title">{{ $entry->title }}</h3>
    @endif

    {{-- Tags --}}
    @if($entry->tags && count($entry->tags) > 0)
        <div class="diary-card-tags">
            @foreach($entry->tags as $tag)
                @if($showOwner)
                    <span class="diary-card-tag">#{{ $tag->name }}</span>
                @else
                    <a href="{{ route('diary.tag', $tag) }}" class="diary-card-tag">#{{ $tag->name }}</a>
                @endif
            @endforeach
        </div>
    @endif

    {{-- Content: native details/summary — zero JS --}}
    <details class="diary-card-details">
        <summary>
            <p class="diary-card-preview">{{ $entry->entry }}</p>
            <span class="diary-card-toggle">Read more</span>
        </summary>
        <p class="diary-card-full">{{ $entry->entry }}</p>
        <button class="diary-card-toggle"
                onclick="this.closest('details').removeAttribute('open')">Show less</button>
    </details>

    @if(! $showOwner && in_array($entry->privacy->value, ['public', 'unlisted'], true))
        <a href="{{ route('diary.public', $entry) }}" class="diary-card-share-link">
            View public page &rarr;
        </a>
    @endif
</article>
