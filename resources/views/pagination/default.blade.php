@if ($paginator->hasPages())
    @php
        $pill = 'inline-flex min-h-10 min-w-10 items-center justify-center rounded-full px-3 text-sm font-medium tabular-nums';
    @endphp

    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-4">
        @if ($paginator->onFirstPage())
            <span class="{{ $pill }} cursor-not-allowed text-gray-400 dark:text-gray-600" aria-disabled="true"
                >&larr; Previous</span>
        @else
            <x-button variant="secondary" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                >&larr; Previous</x-button>
        @endif

        <p class="text-sm text-gray-500 sm:hidden dark:text-gray-400">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </p>

        <ul class="hidden items-center gap-1 sm:flex">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="{{ $pill }} text-gray-400" aria-hidden="true">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page === $paginator->currentPage())
                                <span
                                    class="{{ $pill }} bg-primary-600 text-white"
                                    aria-current="page"
                                >{{ $page }}</span>
                            @else
                                <a
                                    href="{{ $url }}"
                                    class="{{ $pill }} text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                                    aria-label="Page {{ $page }}"
                                >{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>

        @if ($paginator->hasMorePages())
            <x-button variant="secondary" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &rarr;</x-button>
        @else
            <span class="{{ $pill }} cursor-not-allowed text-gray-400 dark:text-gray-600" aria-disabled="true"
                >Next &rarr;</span>
        @endif
    </nav>
@endif
