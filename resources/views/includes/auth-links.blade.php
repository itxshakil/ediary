@guest
@if (Route::has('register'))
<a class="hidden md:block bg-blue-100 active:bg-blue-200 text-blue-800 px-4 py-2 rounded-sm outline-hidden focus:outline-hidden mr-2 mb-1 uppercase shadow-sm hover:shadow-md font-bold text-xs"
    href="/register">{{ __('Register') }}</a>
@endif
<a class="bg-gray-700 text-gray-100 px-4 py-2 rounded-sm outline-hidden focus:outline-hidden mr-2 mb-1 uppercase shadow-sm hover:shadow-md font-bold text-xs"
    href="/login">{{ __('Login') }}</a>
@else
    <details class="relative">
        <summary class="flex cursor-pointer list-none items-center rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-gray-100 transition hover:bg-white/10">
            {{ auth()->user()->username }}
        </summary>

        <div class="absolute right-0 z-50 mt-2 flex min-w-48 flex-col rounded-xl bg-white py-2 shadow-lg ring-1 ring-black/5 dark:bg-gray-800">
            <a href="/home"
               class="px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                Home
            </a>
            <a href="/password/change"
               class="px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                Change Password
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="block w-full px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    Logout
                </button>
            </form>
        </div>
    </details>
@endguest
