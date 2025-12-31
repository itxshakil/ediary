<nav class="bg-gray-800 px-2 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto relative flex items-center justify-between h-16">
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
            <div class="shrink-0 mr-8 text-xl text-gray-100">
                {{-- <img class="block lg:hidden h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-on-dark.svg" alt="" />
              <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-on-dark.svg" alt="" /> --}}
                <a href="/">{{ config('app.name', 'Ediary') }}</a>
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
                    class="bg-gray-700 text-gray-100 px-4 py-2 rounded-sm outline-hidden mr-2 uppercase shadow-sm hover:shadow-md font-bold text-xs"
                    href="{{ route('login') }}"
                >Login</a>

            @endguest


            @auth
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">

                    <!-- Avatar -->
                    <button
                        id="navbarUserMenu"
                        class="flex text-sm border-2 border-transparent focus:outline-hidden focus:border-white transition duration-150 ease-in-out text-gray-100 w-10 h-10 rounded-full overflow-hidden"
                    >
                        <img
                            src="{{ $user->profile->image ?? '/default-avatar.png' }}"
                            alt="{{ $user->username }}"
                            class="w-full h-full object-cover"
                        />
                    </button>

                    <!-- Dropdown -->
                    <div
                        id="dropdownMenu"
                        class="hidden absolute right-0 mt-2 w-48 rounded-md bg-white shadow-xl py-1 z-50"
                    >
                        @if(!$user->email_verified_at)
                            <a href="{{ route('verification.notice') }}"
                               class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-100">
                                Verify Email Address
                            </a>
                        @endif

                        <a href="/user/{{ $user->username }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            My Profile
                        </a>

                        <a href="/home"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Dashboard
                        </a>

                        <a href="/password/change"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Change Password
                        </a>

                        <a href="/settings"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Settings
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
