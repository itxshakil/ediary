@props(['stats'])

<div class="space-y-6">
    {{-- Overview Stats --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
        <x-stat-card label="Total entries" :value="number_format($stats['total_entries'])">
            <x-slot:icon>
                <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </x-slot:icon>
            <span class="font-medium text-green-600 dark:text-green-400">+{{ $stats['entries_this_month'] }}</span> this
            month
        </x-stat-card>
        <x-stat-card label="Total words" :value="number_format($stats['total_words'])" tone="purple">
            <x-slot:icon>
                <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </x-slot:icon>
            Avg {{ number_format($stats['avg_words_per_entry']) }} words per entry
        </x-stat-card>
        <x-stat-card label="Active days" :value="$stats['active_days']" tone="green">
            <x-slot:icon>
                <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </x-slot:icon>
            {{ $stats['days_since_start'] }} days since your first entry
        </x-stat-card>
        <x-stat-card label="Longest entry" :value="number_format($stats['longest_entry'])" tone="orange">
            <x-slot:icon>
                <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </x-slot:icon>
            words
        </x-stat-card>
    </div>

    {{-- Writing Patterns --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Mood Distribution --}}
        <x-card>
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Mood Distribution</h3>
            <div class="space-y-3">
                @foreach ($stats['mood_distribution'] as $mood => $count)
                    @php
                        $mood = \App\Enums\Mood::from($mood);
                        $percentage = $stats['total_entries'] > 0 ? round(($count / $stats['total_entries']) * 100) : 0;
                    @endphp
                    <div>
                        <div class="mb-1 flex items-center justify-between text-sm">
                            <a
                                href="{{ route('diary.mood', $mood) }}"
                                class="hover:text-primary-600 dark:hover:text-primary-400 text-gray-700 dark:text-gray-300"
                            >
                                {{ $mood->emoji() }} {{ $mood->label() }}
                            </a>
                            <span class="text-gray-600 dark:text-gray-400">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div
                                class="from-primary-500 h-2 rounded-full bg-gradient-to-r to-purple-500 transition-all duration-500"
                                style="width: {{ $percentage }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>

        {{-- Writing Time Patterns --}}
        <x-card>
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Best Writing Times</h3>
            <div class="space-y-3">
                @foreach ($stats['time_distribution'] as $period => $count)
                    @php
                        $timeIcons = [
                            'morning' => '🌅', 'afternoon' => '☀️', 'evening' => '🌆', 'night' => '🌙',
                        ];
                        $percentage = $stats['total_entries'] > 0 ? round(($count / $stats['total_entries']) * 100) : 0;
                    @endphp
                    <div>
                        <div class="mb-1 flex items-center justify-between text-sm">
                            <span class="text-gray-700 dark:text-gray-300">
                                {{ $timeIcons[$period] ?? '🕐' }} {{ ucfirst($period) }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400">{{ $count }} entries ({{ $percentage }}%)</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div
                                class="h-2 rounded-full bg-gradient-to-r from-orange-500 to-pink-500 transition-all duration-500"
                                style="width: {{ $percentage }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>

    {{-- Activity Heatmap --}}
    <x-card>
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Activity Heatmap</h3>
        <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">Your writing activity over the past year</p>

        <div class="overflow-x-auto">
            <div class="inline-flex flex-col gap-1">
                {{-- Days of week labels --}}
                <div class="mb-2 flex gap-1">
                    <div class="w-12"></div>
                    @foreach (['Mon', 'Wed', 'Fri'] as $day)
                        <div class="w-12 text-center text-xs text-gray-600 dark:text-gray-400">{{ $day }}</div>
                    @endforeach
                </div>

                {{-- Heatmap grid (52 weeks) --}}
                @for ($week = 0; $week < 52; $week++)
                    <div class="flex gap-1">
                        @if ($week % 4 === 0)
                            <div class="w-12 pr-2 text-right text-xs text-gray-600 dark:text-gray-400">
                                {{ now()->subWeeks(52 - $week)->format('M') }}
                            </div>
                        @else
                            <div class="w-12"></div>
                        @endif
                        @for ($day = 0; $day < 7; $day++)
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
                                    4 => 'bg-green-800 dark:bg-green-400',
                                ];
                            @endphp
                            <div
                                class="w-3 h-3 rounded-md {{ $colors[$intensity] }} cursor-pointer hover:ring-2 hover:ring-primary-500"
                                title="{{ $date->format('M d, Y') }}: {{ $count }} {{ $count === 1 ? 'entry' : 'entries' }}"
                            ></div>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>

        <div class="mt-4 flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
            <span>Less</span>
            <div class="flex gap-1">
                <div class="h-3 w-3 rounded-md bg-gray-100 dark:bg-gray-700"></div>
                <div class="h-3 w-3 rounded-md bg-green-200 dark:bg-green-900"></div>
                <div class="h-3 w-3 rounded-md bg-green-400 dark:bg-green-700"></div>
                <div class="h-3 w-3 rounded-md bg-green-600 dark:bg-green-500"></div>
                <div class="h-3 w-3 rounded-md bg-green-800 dark:bg-green-400"></div>
            </div>
            <span>More</span>
        </div>
    </x-card>

    {{-- Top Tags --}}
    <x-card>
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Top Tags</h3>
        <div class="flex flex-wrap gap-2">
            @foreach ($stats['top_tags'] as $tag => $count)
                <a href="{{ route('diary.tag', $tag) }}" class="chip-tag min-h-9 gap-2 px-3.5 text-sm">
                    #{{ $tag }}
                    <span class="opacity-70">{{ $count }}</span>
                </a>
            @endforeach
        </div>
    </x-card>

    {{-- Achievements --}}
    <x-card>
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Achievements Unlocked</h3>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach ($stats['achievements'] as $achievement)
                <div class="text-center p-4 bg-gradient-to-br {{ $achievement['unlocked'] ? 'from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30' : 'from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800' }} rounded-xl">
                    <div class="text-4xl mb-2 {{ $achievement['unlocked'] ? '' : 'grayscale opacity-50' }}">
                        {{ $achievement['icon'] }}
                    </div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $achievement['name'] }}</p>
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">{{ $achievement['description'] }}</p>
                </div>
            @endforeach
        </div>
    </x-card>
</div>
