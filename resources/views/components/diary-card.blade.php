@php use App\Diary; @endphp
@props(['entry'])

@php
    /**
     * @var Diary $entry
     */
        $fullId = 'full_' . $entry->id;
        $textId = 'text_' . $entry->id;
        $btnId = 'btn_' . $entry->id;
        $actionsId = 'actions_' . $entry->id;

        $fullText = $entry->entry;
        $shortText = mb_substr($entry->entry, 0, 250);
        $shouldTruncate = mb_strlen($fullText) > 250;
        $wordCount = str_word_count($fullText);
        $readTime = max(1, ceil($wordCount / 200));
@endphp

<article
    id="{{ $fullId }}"
    data-full="false"
    class="group bg-white dark:bg-gray-800 rounded-2xl shadow-[0_1px_2px_rgba(0,0,0,0.05)]
           border border-gray-200/70 dark:border-gray-700/60
           overflow-hidden transition-all duration-200
           hover:shadow-md hover:border-gray-300/70 dark:hover:border-gray-600/60">

    <div class="p-6">
        {{-- Header --}}
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                @if($entry->title)
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ $entry->title }}
                    </h3>
                @endif

                <div class="flex items-center gap-3 flex-wrap">
                    <time class="inline-flex items-center gap-1.5 text-xs font-medium
                               text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <time class="js-date" data-time="{{ $entry->created_at->toISOString() }}">
                            {{ $entry->created_at->diffForHumans() }}
                        </time>
                    </time>

                    @if($entry->mood)
                        <span class="text-lg" title="{{ $entry->mood->label() }}">
                            {{ $entry->mood->emoji() }}
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs
                                 bg-gray-100/70 dark:bg-gray-700/60
                                 text-gray-600 dark:text-gray-300 rounded-full">
                        {{ $entry->privacy->emoji() }}
                        {{ $entry->privacy->label() }}
                    </span>

                    @if($entry->is_featured)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs
                                     bg-yellow-100 dark:bg-yellow-900/30
                                     text-yellow-700 dark:text-yellow-300 rounded-full">
                            ⭐ Featured
                        </span>
                    @endif
                </div>

                <div class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                    {{ $readTime }} min read • {{ $wordCount }} words
                </div>
            </div>
        </div>

        {{-- Tags --}}
        @if($entry->tags && count($entry->tags) > 0)
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($entry->tags as $tag)
                    <a href="{{ route('diary.tag', $tag) }}"
                       class="inline-flex items-center px-2.5 py-1 text-xs font-medium
                              bg-blue-50 dark:bg-blue-900/20
                              text-blue-700 dark:text-blue-300
                              rounded-full hover:bg-blue-100
                              dark:hover:bg-blue-900/30 transition-colors">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Content --}}
        <div class="prose prose-gray dark:prose-invert max-w-none">
            <p id="{{ $textId }}"
               class="text-gray-700 dark:text-gray-300 _whitespace-pre-wrap
                      leading-relaxed text-[15px]">
                {{ $shouldTruncate ? $shortText . '...' : $fullText }}
            </p>
        </div>

        {{-- Footer --}}
        <div class="mt-5 pt-4 border-t border-gray-100/70 dark:border-gray-700/60
                    flex items-center justify-between">
            @if($shouldTruncate)
                <button
                    id="{{ $btnId }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium
                           text-blue-600 dark:text-blue-400
                           hover:text-blue-700 dark:hover:text-blue-300
                           transition-colors duration-200 group/btn">
                    <span class="btn-text">Read more</span>
                    <svg class="w-4 h-4 transition-transform duration-200
                                group-hover/btn:translate-x-0.5 arrow-icon"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @else
                <div></div>
            @endif
        </div>
    </div>
</article>

@if($shouldTruncate)
    <script>
        (function(){
            const fullEl = document.getElementById("{{ $fullId }}");
            const textEl = document.getElementById("{{ $textId }}");
            const btnEl  = document.getElementById("{{ $btnId }}");

            const FULL_TEXT  = @json($fullText);
            const SHORT_TEXT = @json($shortText) + '...';

            btnEl.addEventListener("click", () => {
                const isFull = fullEl.dataset.full === "true";

                textEl.textContent = isFull ? SHORT_TEXT : FULL_TEXT;
                btnEl.querySelector('.btn-text').textContent = isFull ? "Read more" : "Show less";

                const arrow = btnEl.querySelector('.arrow-icon');
                arrow.style.transform = isFull ? 'rotate(0deg)' : 'rotate(90deg)';

                fullEl.dataset.full = isFull ? "false" : "true";

                if (!isFull) {
                    setTimeout(() => {
                        fullEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 100);
                }
            });
        })();
    </script>
@endif

<script>
    function toggleActions(id) {
        const menu = document.getElementById(id);
        const allMenus = document.querySelectorAll('[id^="actions_"]');

        allMenus.forEach(m => {
            if (m.id !== id) m.classList.add('hidden');
        });

        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', (e) => {
        if (!e.target.closest('[id^="actions_"]') && !e.target.closest('button')) {
            document.querySelectorAll('[id^="actions_"]').forEach(m => m.classList.add('hidden'));
        }
    });
</script>
