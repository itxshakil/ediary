@php use App\User; @endphp
@props([
    /** @var User */
    'user',
])

<article {{ $attributes->class(['group bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600']) }}>
    <div class="p-2 md:p-6">
        <div class="flex items-start gap-2 md:gap-4">
            <a href="{{ route('profile.show', $user->username) }}" class="shrink-0">
                <img
                    src="{{ $user->profile->image }}"
                    alt="Profile picture of {{ $user->username }}"
                    class="h-12 w-12 rounded-full border-2 border-gray-200 object-cover transition-transform duration-200 group-hover:scale-105 md:h-20 md:w-20 dark:border-gray-700"
                />
            </a>

            <div class="min-w-0 flex-1">
                <div class="flex flex-col items-start justify-between gap-4 md:flex-row">
                    <div class="flex-1">
                        <a href="{{ route('profile.show', $user->username) }}" class="group/name block">
                            <h3 class="text-lg font-semibold text-gray-900 transition-colors group-hover/name:text-blue-600 dark:text-white dark:group-hover/name:text-blue-400">
                                {{ $user->profile->name }}
                            </h3>
                        </a>
                        <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">{{ "@$user->username" }}</p>

                        <div class="mt-3 flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($user->profile->follower_count) }}</span>
                                <span>{{ $user->profile->follower_count === 1 ? 'follower' : 'followers' }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($user->profile->diaries_count ?? 0) }}</span>
                                <span>{{ ($user->profile->diaries_count ?? 0) === 1 ? 'entry' : 'entries' }}</span>
                            </div>
                        </div>

                        @if ($user->profile->bio)
                            <p class="mt-3 line-clamp-2 hidden text-sm text-gray-700 md:block dark:text-gray-300">
                                {{ $user->profile->bio }}
                            </p>
                        @endif
                    </div>

                    <div class="w-full shrink-0 md:w-auto">
                        @auth
                            @if (auth()->id() !== $user->id)
                                <a
                                    href="{{ route('profile.show', $user->username) }}"
                                    class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-all duration-200 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none dark:focus:ring-offset-gray-800"
                                >
                                    View Profile
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-4 py-2 text-sm font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                    You
                                </span>
                            @endif
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                            >
                                Follow
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
