@inject('navigation', App\Support\Navigation::class)

<nav class="navbar-glass sticky top-0 z-40 px-4 sm:px-6 lg:px-8" aria-label="Main">
    <div class="relative mx-auto flex h-16 max-w-7xl items-center justify-between gap-4">
        <div class="flex min-w-0 items-center gap-6">
            <a href="{{ url('/') }}" class="shrink-0 text-xl font-bold text-gray-900 dark:text-white">
                {{ config('app.name', 'Ediary') }}
            </a>
            <div class="hidden items-center gap-1 sm:flex">
                @foreach (auth()->check() ? collect($navigation->journal())->reject(fn ($item) => $item['key'] === 'write') : $navigation->site() as $item)
                    <a
                        href="{{ $item['url'] }}"
                        @class([
                            'rounded-full px-3 py-2 text-sm font-medium transition-colors',
                            'bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300' => $item['active'],
                            'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white' => ! $item['active'],
                        ])
                        @if ($item['active']) aria-current="page" @endif
                    >{{ $item['label'] }}</a>
                @endforeach
            </div>
        </div>
        @auth
            <form action="{{ route('search') }}" method="get" role="search" class="ml-auto hidden md:block">
                <label for="search" class="sr-only">Search people</label>
                <x-form.input
                    id="search"
                    placeholder="Search people…"
                    class="w-56"
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    autocomplete="off"
                    required
                />
            </form>
            <x-button
                variant="ghost"
                size="icon"
                href="{{ route('search') }}"
                class="ml-auto md:hidden"
                aria-label="Search people"
            >
                <svg aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
            </x-button>
        @endauth
        @php
            $user = Auth::user();
        @endphp

        <div class="flex shrink-0 items-center">
            @guest
                <!-- Guest View -->
                <div class="flex items-center gap-2">
                    <x-button variant="secondary" size="sm" href="{{ route('login') }}">Log in</x-button>
                    <x-button size="sm" href="{{ route('register') }}">Sign up</x-button>
                </div>

            @endguest

            @auth
                <!-- User Dropdown — native <details>/<summary>, zero JS -->
                <details class="nav-details">
                    <summary
                        class="flex size-10 cursor-pointer overflow-hidden rounded-full ring-1 ring-black/5 dark:ring-white/10"
                        aria-label="Account menu"
                    >
                        <img src="{{ $user->profile->image }}" alt="" class="h-full w-full object-cover" />
                    </summary>

                    <div class="nav-dropdown">
                        @if (! $user->email_verified_at)
                            <a href="{{ route('verification.notice') }}" class="text-red-500!">
                                Verify Email Address
                            </a>
                        @endif

                        <a href="{{ route('diary.create') }}"> Write Entry </a>

                        <a href="/user/{{ $user->username }}"> My Profile </a>

                        <a href="/home"> Dashboard </a>

                        <a href="{{ route('diary.stats') }}"> Stats </a>

                        <a href="/password/change"> Change Password </a>

                        <a href="/settings"> Settings </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" data-logout>
                            @csrf
                            <button>Logout</button>
                        </form>
                    </div>
                </details>
            @endauth
        </div>
    </div>
</nav>
