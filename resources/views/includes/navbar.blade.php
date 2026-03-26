<nav class="navbar-glass px-2 sm:px-6 lg:px-8 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto relative flex items-center justify-between h-16">
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
            <div class="shrink-0 mr-8 text-xl text-gray-900 dark:text-white font-bold">
                <a href="/">{{ config('app.name', 'Ediary') }}</a>
            </div>
            <div class="hidden sm:flex items-center space-x-4">
                <a href="/blog" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Blog</a>
                <a href="/about" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                <a href="/faq" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">FAQ</a>
            </div>
        </div>
        @auth
        <form action="/search" method="get" class="w-full text-right">
            <x-form.input id="search" placeholder="Search user..." class="sm:w-56 w-32" type="search" name="q" value="{{ request('q') }}" autocomplete="off" required />
            @error('q')
            <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
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
                    class="hidden md:block bg-blue-100 active:bg-blue-200 text-blue-800 px-4 py-2 rounded-sm outline-hidden mr-2 uppercase shadow-sm hover:shadow-md font-bold text-xs"
                    href="{{ route('register') }}"
                >Register</a>

                <a
                    class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2 rounded-sm outline-hidden mr-2 uppercase shadow-sm hover:shadow-md font-bold text-xs"
                    href="{{ route('login') }}"
                >Login</a>

            @endguest


            @auth
                <!-- User Dropdown — native <details>/<summary>, zero JS -->
                <details class="nav-details ml-3">
                    <summary class="flex text-sm border-2 border-transparent focus:outline-none focus:border-blue-400 transition duration-150 ease-in-out w-10 h-10 rounded-full overflow-hidden">
                        <img
                            src="{{ $user->profile->image ?? '/default-avatar.png' }}"
                            alt="{{ $user->username }}"
                            class="w-full h-full object-cover"
                        />
                    </summary>

                    <div class="nav-dropdown">
                        @if(!$user->email_verified_at)
                            <a href="{{ route('verification.notice') }}"
                               class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Verify Email Address
                            </a>
                        @endif

                        <a href="{{ route('diary.create') }}"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Write Entry
                        </a>

                        <a href="/user/{{ $user->username }}"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            My Profile
                        </a>

                        <a href="/home"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Dashboard
                        </a>

                        <a href="/password/change"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Change Password
                        </a>

                        <a href="/settings"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Settings
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                </details>
            @endauth
        </div>
    </div>
</nav>
