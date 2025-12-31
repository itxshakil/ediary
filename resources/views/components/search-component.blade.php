{{-- Search & Filter Component --}}
{{-- Search & Filter Component --}}
<div class="bg-white dark:bg-gray-800
            rounded-2xl
            shadow-sm
            border border-gray-200/70 dark:border-gray-700/60
            p-6 mb-6">

    <form action="{{ route('diary.search') }}" method="GET" id="search-form">

        {{-- Main Search Bar --}}
        <div class="flex gap-3 mb-4">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2
                            w-5 h-5 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>

                <input
                    type="text"
                    name="q"
                    id="search-input"
                    value="{{ request('q') }}"
                    placeholder="Search your diary entries..."
                    class="w-full pl-12 pr-4 py-3
                           text-sm
                           text-gray-900 dark:text-white
                           bg-gray-50 dark:bg-gray-900
                           border border-gray-300 dark:border-gray-600
                           rounded-xl
                           focus:ring-2 focus:ring-blue-500/60
                           focus:border-transparent
                           transition"
                />
            </div>

            <button
                type="submit"
                class="inline-flex items-center gap-2
                       px-6 py-3
                       bg-blue-600 hover:bg-blue-700
                       text-white text-sm font-medium
                       rounded-xl
                       shadow-sm hover:shadow-md
                       transition
                       focus:ring-2 focus:ring-blue-500/60
                       focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                Search
            </button>
        </div>

        {{-- Advanced Filters --}}
        <div id="advanced-filters"
             class="hidden space-y-5 pt-5
                    border-t border-gray-200/70 dark:border-gray-700/60">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Date Range --}}
                <div>
                    <label class="block text-sm font-medium
                                  text-gray-700 dark:text-gray-300 mb-2">
                        Date Range
                    </label>
                    <select name="date_range"
                            class="w-full px-3 py-2 text-sm
                                   bg-white dark:bg-gray-900
                                   border border-gray-300 dark:border-gray-600
                                   rounded-xl
                                   focus:ring-2 focus:ring-blue-500/60">
                        <option value="">All time</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This week</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This month</option>
                        <option value="year" {{ request('date_range') == 'year' ? 'selected' : '' }}>This year</option>
                        <option value="custom" {{ request('date_range') == 'custom' ? 'selected' : '' }}>Custom range</option>
                    </select>
                </div>

                {{-- Mood --}}
                <div>
                    <label class="block text-sm font-medium
                                  text-gray-700 dark:text-gray-300 mb-2">
                        Mood
                    </label>
                    <select name="mood"
                            class="w-full px-3 py-2 text-sm
                                   bg-white dark:bg-gray-900
                                   border border-gray-300 dark:border-gray-600
                                   rounded-xl
                                   focus:ring-2 focus:ring-blue-500/60">
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

                {{-- Privacy --}}
                <div>
                    <label class="block text-sm font-medium
                                  text-gray-700 dark:text-gray-300 mb-2">
                        Privacy
                    </label>
                    <select name="privacy"
                            class="w-full px-3 py-2 text-sm
                                   bg-white dark:bg-gray-900
                                   border border-gray-300 dark:border-gray-600
                                   rounded-xl
                                   focus:ring-2 focus:ring-blue-500/60">
                        <option value="">All entries</option>
                        <option value="private" {{ request('privacy') == 'private' ? 'selected' : '' }}>🔒 Private</option>
                        <option value="followers" {{ request('privacy') == 'followers' ? 'selected' : '' }}>👥 Followers</option>
                        <option value="public" {{ request('privacy') == 'public' ? 'selected' : '' }}>🌍 Public</option>
                        <option value="unlisted" {{ request('privacy') == 'unlisted' ? 'selected' : '' }}>🔗 Unlisted</option>
                    </select>
                </div>

                {{-- Sort --}}
                <div>
                    <label class="block text-sm font-medium
                                  text-gray-700 dark:text-gray-300 mb-2">
                        Sort By
                    </label>
                    <select name="sort"
                            class="w-full px-3 py-2 text-sm
                                   bg-white dark:bg-gray-900
                                   border border-gray-300 dark:border-gray-600
                                   rounded-xl
                                   focus:ring-2 focus:ring-blue-500/60">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest first</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest first</option>
                        <option value="longest" {{ request('sort') == 'longest' ? 'selected' : '' }}>Longest entries</option>
                        <option value="shortest" {{ request('sort') == 'shortest' ? 'selected' : '' }}>Shortest entries</option>
                    </select>
                </div>
            </div>

            {{-- Custom Date --}}
            <div id="custom-date-range" class="hidden grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-3 py-2 text-sm
                                  bg-white dark:bg-gray-900
                                  border border-gray-300 dark:border-gray-600
                                  rounded-xl
                                  focus:ring-2 focus:ring-blue-500/60">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-3 py-2 text-sm
                                  bg-white dark:bg-gray-900
                                  border border-gray-300 dark:border-gray-600
                                  rounded-xl
                                  focus:ring-2 focus:ring-blue-500/60">
                </div>
            </div>

            {{-- Checkboxes --}}
            <div class="flex flex-wrap items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1"
                           {{ request('featured') ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600
                                  rounded
                                  focus:ring-2 focus:ring-blue-500/60">
                    <span class="text-sm text-gray-700 dark:text-gray-300">⭐ Featured only</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="has_title" value="1"
                           {{ request('has_title') ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600
                                  rounded
                                  focus:ring-2 focus:ring-blue-500/60">
                    <span class="text-sm text-gray-700 dark:text-gray-300">📝 Has title</span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-5 py-2
                               bg-blue-600 hover:bg-blue-700
                               text-white text-sm font-medium
                               rounded-xl
                               transition">
                    Apply Filters
                </button>

                <a href="{{ route('home') }}"
                   class="px-5 py-2
                          text-gray-700 dark:text-gray-300
                          hover:bg-gray-100 dark:hover:bg-gray-700
                          text-sm font-medium
                          rounded-xl
                          transition">
                    Clear All
                </a>
            </div>
        </div>

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
