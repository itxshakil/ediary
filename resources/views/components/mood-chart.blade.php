@props(['moodData' => []])

@if(count($moodData) > 0)
<div class="bg-white/90 dark:bg-gray-800/70
            rounded-2xl
            border border-gray-200/70 dark:border-gray-700/60
            shadow-[0_1px_2px_rgba(0,0,0,0.05)]
            p-5">

    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
        Mood This Week
    </h3>

    <div class="flex items-end justify-between gap-1">
        @foreach($moodData as $day)
            @php
                $score = $day['score'] ?? 0;
                $heightMap = [2 => 'h-12', 1 => 'h-9', 0 => 'h-6', -1 => 'h-4', -2 => 'h-2'];
                $colorMap  = [
                    2  => 'bg-green-400 dark:bg-green-500',
                    1  => 'bg-teal-400 dark:bg-teal-500',
                    0  => 'bg-gray-300 dark:bg-gray-600',
                    -1 => 'bg-orange-400 dark:bg-orange-500',
                    -2 => 'bg-red-400 dark:bg-red-500',
                ];
                $barHeight = $heightMap[$score] ?? 'h-6';
                $barColor  = $colorMap[$score]  ?? 'bg-gray-300 dark:bg-gray-600';
            @endphp
            <div class="flex flex-col items-center gap-1 flex-1">
                <span class="text-lg leading-none" title="{{ $day['label'] ?? '' }}">
                    {{ $day['emoji'] ?? '😐' }}
                </span>
                <div class="w-full rounded-full {{ $barColor }} {{ $barHeight }} transition-all duration-300"></div>
                <span class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">
                    {{ $day['day'] ?? '' }}
                </span>
            </div>
        @endforeach
    </div>
</div>
@endif
