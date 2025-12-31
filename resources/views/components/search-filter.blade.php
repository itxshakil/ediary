{{-- Search & Filter Component --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
    <form action="{{ route('diary.search') }}" method="GET" id="search-form">
        {{-- Main Search Bar --}}
        <div class="flex gap-3 mb-4">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    type="text"
                    name="q"
                    id="search-input"
                    value="{{ request('q') }}"
                    placeholder="Search your diary entries..."
                    class="w-full pl-12 pr-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                />
            </div>
            <button
                type="submit"
                class="inline-flex items-center gap-2
                       px-6 py-2.5
                       bg-blue-600 hover:bg-blue-700
                       text-white font-medium
                       rounded-full
                       shadow-sm hover:shadow-md
                       transition
                       focus:ring-2 focus:ring-blue-500/60
                       focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                Search
            </button>
            <button
                type="button"
                id="filter-toggle"
                class="px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                Filters
            </button>
        </div>

        {{-- Advanced Filters (collapsible) --}}
        <div id="advanced-filters" class="hidden space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Date Range --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Date Range
                    </label>
                    <select name="date_range" class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All time</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This week</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This month</option>
                        <option value="year" {{ request('date_range') == 'year' ? 'selected' : '' }}>This year</option>
                        <option value="custom" {{ request('date_range') == 'custom' ? 'selected' : '' }}>Custom range</option>
                    </select>
                </div>

                {{-- Mood Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mood
                    </label>
                    <select name="mood" class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All moods</option>
                        <option value="happy" {{ request('mood') == 'happy' ? 'selected' : '' }}>😊 Happy</option>
                        <option value="sad" {{ request('mood') == 'sad' ? 'selected' : '' }}>😔 Sad</option>
                        <option value="calm" {{ request('mood') == 'calm' ? 'selected' : '' }}>😌 Calm</option>
                        <option value="angry" {{ request('mood') == 'angry' ? 'selected' : '' }}>😤 Angry</option>
                        <option value="anxious" {{ request('mood') == 'anxious' ? 'selected' : '' }}>😰 Anxious</option>
                        <option value="thoughtful" {{ request('mood') == 'thoughtful' ? 'selected' : '' }}>🤔 Thoughtful</option>
                        <option value="tired" {{ request('mood') == 'tired' ? 'selected' : '' }}>😴 Tired</option>
                        <option value="excited" {{ request('mood') == 'excited' ? 'selected' : '' }}>🥳 Excited</option>
                        <option value="neutral" {{ request('mood') == 'neutral' ? 'selected' : '' }}>😐 Neutral</option>
                    </select>
                </div>

                {{-- Privacy Level --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Privacy
                    </label>
                    <select name="privacy" class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All entries</option>
                        <option value="private" {{ request('privacy') == 'private' ? 'selected' : '' }}>🔒 Private</option>
                        <option value="followers" {{ request('privacy') == 'followers' ? 'selected' : '' }}>👥 Followers</option>
                        <option value="public" {{ request('privacy') == 'public' ? 'selected' : '' }}>🌍 Public</option>
                        <option value="unlisted" {{ request('privacy') == 'unlisted' ? 'selected' : '' }}>🔗 Unlisted</option>
                    </select>
                </div>

                {{-- Sort By --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Sort By
                    </label>
                    <select name="sort" class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest first</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest first</option>
                        <option value="longest" {{ request('sort') == 'longest' ? 'selected' : '' }}>Longest entries</option>
                        <option value="shortest" {{ request('sort') == 'shortest' ? 'selected' : '' }}>Shortest entries</option>
                    </select>
                </div>
            </div>

            {{-- Custom Date Range --}}
            <div id="custom-date-range" class="hidden grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Featured Only --}}
            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">⭐ Featured only</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="has_title" value="1" {{ request('has_title') ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">📝 Has title</span>
                </label>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Apply Filters
                </button>
                <a href="{{ route('home') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium rounded-lg transition-colors">
                    Clear All
                </a>
            </div>
        </div>

        {{-- Active Filters Display --}}
        @if(request()->hasAny(['q', 'mood', 'privacy', 'date_range', 'featured', 'has_title']))
            <div class="mt-4 flex items-center gap-2 flex-wrap">
                <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>

                @if(request('q'))
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                        "{{ request('q') }}"
                        <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="hover:text-blue-900">×</a>
                    </span>
                @endif

                @if(request('mood'))
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                        Mood: {{ ucfirst(request('mood')) }}
                        <a href="{{ request()->fullUrlWithQuery(['mood' => null]) }}" class="hover:text-blue-900">×</a>
                    </span>
                @endif

                @if(request('privacy'))
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                        Privacy: {{ ucfirst(request('privacy')) }}
                        <a href="{{ request()->fullUrlWithQuery(['privacy' => null]) }}" class="hover:text-blue-900">×</a>
                    </span>
                @endif

                @if(request('date_range'))
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                        Date: {{ ucfirst(request('date_range')) }}
                        <a href="{{ request()->fullUrlWithQuery(['date_range' => null]) }}" class="hover:text-blue-900">×</a>
                    </span>
                @endif
            </div>
        @endif
    </form>
</div>

<script>
    // Toggle advanced filters
    const filterToggle = document.getElementById('filter-toggle');
    const advancedFilters = document.getElementById('advanced-filters');

    filterToggle?.addEventListener('click', () => {
        advancedFilters.classList.toggle('hidden');
    });

    // Show custom date range when selected
    const dateRangeSelect = document.querySelector('select[name="date_range"]');
    const customDateRange = document.getElementById('custom-date-range');

    dateRangeSelect?.addEventListener('change', (e) => {
        if (e.target.value === 'custom') {
            customDateRange.classList.remove('hidden');
        } else {
            customDateRange.classList.add('hidden');
        }
    });

    // Show custom date range if already selected
    if (dateRangeSelect?.value === 'custom') {
        customDateRange?.classList.remove('hidden');
    }

    // Live search with debounce
    const searchInput = document.getElementById('search-input');
    let searchTimeout;

    searchInput?.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (e.target.value.length > 2 || e.target.value.length === 0) {
                // Auto-submit after typing stops
                // document.getElementById('search-form').submit();
            }
        }, 500);
    });
</script><?php
