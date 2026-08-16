@props(['streak' => 0, 'longestStreak' => 0, 'todayWritten' => false])

<div class="overflow-hidden rounded-xl bg-gradient-to-br from-orange-500 to-red-600 text-white shadow-lg">
    <div class="p-6">
        {{-- Main Streak Display --}}
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="animate-pulse text-5xl">🔥</div>
                <div>
                    <div class="text-4xl font-bold">{{ $streak }}</div>
                    <div class="text-sm opacity-90">Day Streak</div>
                </div>
            </div>

            <div class="text-right">
                <div class="text-2xl font-semibold">{{ $longestStreak }}</div>
                <div class="text-xs opacity-90">Best Streak</div>
            </div>
        </div>

        {{-- Today's Status --}}
        <div class="mb-4 rounded-lg bg-white/20 p-3 backdrop-blur-sm">
            @if ($todayWritten)
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">✨ Today's entry complete!</span>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="text-sm font-medium">Write today to keep your streak!</span>
                </div>
            @endif
        </div>

        {{-- Weekly Progress --}}
        <div class="space-y-2">
            <div class="flex items-center justify-between text-xs opacity-90">
                <span>This Week</span>
                <span>{{ min($streak, 7) }}/7 days</span>
            </div>
            <div class="flex gap-1">
                @for ($i = 0; $i < 7; $i++)
                    <div class="flex-1 h-2 rounded-full {{ $i < min($streak, 7) ? 'bg-white' : 'bg-white/20' }}"></div>
                @endfor
            </div>
        </div>

        {{-- Motivational Message --}}
        <div class="mt-4 border-t border-white/20 pt-4 text-center text-sm">
            @if ($streak === 0)
                <p class="opacity-90">🌱 Start your journey today!</p>
            @elseif ($streak < 7)
                <p class="opacity-90">💪 Keep going! {{ 7 - $streak }} days to complete your first week!</p>
            @elseif ($streak < 30)
                <p class="opacity-90">🎯 Amazing progress! {{ 30 - $streak }} days to 30-day milestone!</p>
            @elseif ($streak < 100)
                <p class="opacity-90">🏆 You're on fire! {{ 100 - $streak }} days to 100-day legend status!</p>
            @elseif ($streak < 365)
                <p class="opacity-90">🌟 Incredible! {{ 365 - $streak }} days to one year streak!</p>
            @else
                <p class="opacity-90">👑 You're a diary legend! Keep it up!</p>
            @endif
        </div>

        {{-- Streak Freeze Cards (if available) --}}
        @if (isset($freezeCards) && $freezeCards > 0)
            <div class="mt-4 border-t border-white/20 pt-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="opacity-90">❄️ Streak Freeze Cards</span>
                    <span class="font-bold">{{ $freezeCards }} available</span>
                </div>
                <p class="mt-1 text-xs opacity-75">Use when you miss a day to save your streak</p>
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes pulse {
        0%,
        100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    .animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }
</style>
