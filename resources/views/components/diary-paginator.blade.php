@props(['collection'])

@if ($collection->hasPages())
    <nav class="flex items-center justify-center mt-8" aria-label="Pagination">
        <div class="inline-flex items-center gap-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-1">

            {{-- Previous Button --}}
            @if ($collection->onFirstPage())
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-md text-gray-400 dark:text-gray-600 cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            @else
                <a href="{{ $collection->previousPageUrl() }}"
                   class="inline-flex items-center justify-center w-10 h-10 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                   aria-label="Previous page">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- Page Numbers --}}
            <div class="flex items-center gap-1 px-2">
                @foreach ($collection->links()->elements[0] as $page => $url)
                    @if ($page == $collection->currentPage())
                        <span class="inline-flex items-center justify-center min-w-[2.5rem] h-10 px-3 bg-blue-600 text-white text-sm font-medium rounded-md"
                              aria-current="page">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="inline-flex items-center justify-center min-w-[2.5rem] h-10 px-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200"
                           aria-label="Go to page {{ $page }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Next Button --}}
            @if ($collection->hasMorePages())
                <a href="{{ $collection->nextPageUrl() }}"
                   class="inline-flex items-center justify-center w-10 h-10 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                   aria-label="Next page">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-md text-gray-400 dark:text-gray-600 cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </div>

        {{-- Page info text (optional) --}}
        <div class="hidden sm:block ml-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Page <span class="font-medium">{{ $collection->currentPage() }}</span> of <span class="font-medium">{{ $collection->lastPage() }}</span>
            </p>
        </div>
    </nav>
@endif
