<nav class="navbar-glass sticky top-0 z-40 px-2 sm:px-6 lg:px-8">
    <div class="relative mx-auto flex h-16 max-w-7xl items-center justify-between">
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
            <div class="mr-8 shrink-0 text-xl font-bold text-gray-900 dark:text-white">
                <a href="/">{{ config('app.name', 'Ediary') }}</a>
            </div>
            <div class="hidden items-center space-x-4 sm:flex">
                @auth
                    <a
                        href="{{ route('diary.explore') }}"
                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                    >Explore</a>
                @endauth
                <a
                    href="/blog"
                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                >Blog</a>
                <a
                    href="/about"
                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                >About</a>
                <a
                    href="/faq"
                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                >FAQ</a>
            </div>
        </div>
        @auth
            <form action="/search" method="get" class="w-full text-right">
                <x-form.input
                    id="search"
                    placeholder="Search user..."
                    class="w-32 sm:w-56"
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    autocomplete="off"
                    required
                />
                @error('q')
                    <p class="text-xs text-red-500 italic" role="alert">{{ $message }}</p>
                @enderror
            </form>
        @endauth
        @php
            $user = Auth::user();
        @endphp

        <div class="flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            @guest
                <!-- Guest View -->
                <a
                    class="mr-2 hidden rounded-sm bg-blue-100 px-4 py-2 text-xs font-bold text-blue-800 uppercase shadow-sm outline-hidden hover:shadow-md active:bg-blue-200 md:block"
                    href="{{ route('register') }}"
                >Register</a>

                <a
                    class="mr-2 rounded-sm bg-gray-200 px-4 py-2 text-xs font-bold text-gray-800 uppercase shadow-sm outline-hidden hover:shadow-md dark:bg-gray-700 dark:text-gray-100"
                    href="{{ route('login') }}"
                >Login</a>

            @endguest

            @auth
                <!-- User Dropdown — native <details>/<summary>, zero JS -->
                <details class="nav-details ml-3">
                    <summary class="flex h-10 w-10 overflow-hidden rounded-full border-2 border-transparent text-sm transition duration-150 ease-in-out focus:border-blue-400 focus:outline-none">
                        <img
                            src="{{ $user->profile->image ?? '/default-avatar.png' }}"
                            alt="{{ $user->username }}"
                            class="h-full w-full object-cover"
                        />
                    </summary>

                    <div class="nav-dropdown">
                        @if (! $user->email_verified_at)
                            <a
                                href="{{ route('verification.notice') }}"
                                class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                Verify Email Address
                            </a>
                        @endif

                        <a
                            href="{{ route('diary.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                        >
                            Write Entry
                        </a>

                        <a
                            href="/user/{{ $user->username }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                        >
                            My Profile
                        </a>

                        <a
                            href="/home"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                        >
                            Dashboard
                        </a>

                        <a
                            href="/password/change"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                        >
                            Change Password
                        </a>

                        <a
                            href="/settings"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                        >
                            Settings
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </details>
            @endauth
        </div>
    </div>
</nav>
