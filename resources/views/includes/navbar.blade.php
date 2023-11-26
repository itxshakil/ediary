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
            <input
                class="sm:w-48 w-32 sm:m-1 mr-1 px-2 py-1  sm:px-3 sm:py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('q') border-red-500 @enderror"
                id="q" type="search" name="q" placeholder="Search user..." autocomplete="off" required />
            @error('q')
            <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
            @enderror
        </form>
        @endauth
        <auth-links>
        </auth-links>
    </div>
</nav>