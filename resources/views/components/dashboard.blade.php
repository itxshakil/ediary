@props(['stats'])

<div class="space-y-6">
    {{-- Overview Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Entries --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Entries</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_entries']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                <span class="text-green-600 dark:text-green-400 font-medium">+{{ $stats['entries_this_month'] }}</span>
                <span class="text-gray-600 dark:text-gray-400 ml-1">this month</span>
            </div>
        </div>

        {{-- Total Words --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Words</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_words']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                <span class="text-gray-600 dark:text-gray-400">Avg: {{ number_format($stats['avg_words_per_entry']) }} words/entry</span>
            </div>
        </div>

        {{-- Active Days --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Active Days</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['active_days'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                <span class="text-gray-600 dark:text-gray-400">{{ $stats['days_since_start'] }} days total</span>
            </div>
        </div>

        {{-- Longest Entry --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Longest Entry</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['longest_entry']) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                <span class="text-gray-600 dark:text-gray-400">words</span>
            </div>
        </div>
    </div>

    {{-- Writing Patterns --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Mood Distribution --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Mood Distribution</h3>
            <div class="space-y-3">
                @foreach($stats['mood_distribution'] as $mood => $count)
                    @php
                        $moodEmojis = [
                            'happy' => '😊', 'sad' => '😔', 'calm' => '😌', 'angry' => '😤',
                            'anxious' => '😰', 'thoughtful' => '🤔', 'tired' => '😴',
                            'excited' => '🥳', 'neutral' => '😐'
                        ];
                        $percentage = $stats['total_entries'] > 0 ? round(($count / $stats['total_entries']) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-gray-700 dark:text-gray-300">
                                {{ $moodEmojis[$mood] ?? '😊' }} {{ ucfirst($mood) }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500"
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Writing Time Patterns --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Best Writing Times</h3>
            <div class="space-y-3">
                @foreach($stats['time_distribution'] as $period => $count)
                    @php
                        $timeIcons = [
                            'morning' => '🌅', 'afternoon' => '☀️', 'evening' => '🌆', 'night' => '🌙'
                        ];
                        $percentage = $stats['total_entries'] > 0 ? round(($count / $stats['total_entries']) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-gray-700 dark:text-gray-300">
                                {{ $timeIcons[$period] ?? '🕐' }} {{ ucfirst($period) }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400">{{ $count }} entries ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-orange-500 to-pink-500 h-2 rounded-full transition-all duration-500"
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Activity Heatmap --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Activity Heatmap</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Your writing activity over the past year</p>

        <div class="overflow-x-auto">
            <div class="inline-flex flex-col gap-1">
                {{-- Days of week labels --}}
                <div class="flex gap-1 mb-2">
                    <div class="w-12"></div>
                    @foreach(['Mon', 'Wed', 'Fri'] as $day)
                        <div class="text-xs text-gray-600 dark:text-gray-400 w-12 text-center">{{ $day }}</div>
                    @endforeach
                </div>

                {{-- Heatmap grid (52 weeks) --}}
                @for($week = 0; $week < 52; $week++)
                    <div class="flex gap-1">
                        @if($week % 4 === 0)
                            <div class="w-12 text-xs text-gray-600 dark:text-gray-400 pr-2 text-right">
                                {{ now()->subWeeks(52 - $week)->format('M') }}
                            </div>
                        @else
                            <div class="w-12"></div>
                        @endif
                        @for($day = 0; $day < 7; $day++)
                            @php
                                $date = now()->subWeeks(52 - $week)->startOfWeek()->addDays($day);
                                $hasEntry = isset($stats['heatmap_data'][$date->format('Y-m-d')]);
                                $count = $stats['heatmap_data'][$date->format('Y-m-d')] ?? 0;
                                $intensity = $count > 0 ? min(4, ceil($count / 2)) : 0;
                                $colors = [
                                    0 => 'bg-gray-100 dark:bg-gray-700',
                                    1 => 'bg-green-200 dark:bg-green-900',
                                    2 => 'bg-green-400 dark:bg-green-700',
                                    3 => 'bg-green-600 dark:bg-green-500',
                                    4 => 'bg-green-800 dark:bg-green-400'
                                ];
                            @endphp
                            <div class="w-3 h-3 rounded-sm {{ $colors[$intensity] }} cursor-pointer hover:ring-2 hover:ring-blue-500"
                                 title="{{ $date->format('M d, Y') }}: {{ $count }} {{ $count === 1 ? 'entry' : 'entries' }}">
                            </div>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>

        <div class="flex items-center gap-2 mt-4 text-xs text-gray-600 dark:text-gray-400">
            <span>Less</span>
            <div class="flex gap-1">
                <div class="w-3 h-3 bg-gray-100 dark:bg-gray-700 rounded-sm"></div>
                <div class="w-3 h-3 bg-green-200 dark:bg-green-900 rounded-sm"></div>
                <div class="w-3 h-3 bg-green-400 dark:bg-green-700 rounded-sm"></div>
                <div class="w-3 h-3 bg-green-600 dark:bg-green-500 rounded-sm"></div>
                <div class="w-3 h-3 bg-green-800 dark:bg-green-400 rounded-sm"></div>
            </div>
            <span>More</span>
        </div>
    </div>

    {{-- Top Tags --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Tags</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($stats['top_tags'] as $tag => $count)
                <a href="{{ route('diary.tag', $tag) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <span class="font-medium">#{{ $tag }}</span>
                    <span class="text-sm opacity-75">{{ $count }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Achievements --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Achievements Unlocked</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($stats['achievements'] as $achievement)
                <div class="text-center p-4 bg-gradient-to-br {{ $achievement['unlocked'] ? 'from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30' : 'from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800' }} rounded-lg">
                    <div class="text-4xl mb-2 {{ $achievement['unlocked'] ? '' : 'grayscale opacity-50' }}">{{ $achievement['icon'] }}</div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $achievement['name'] }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $achievement['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
