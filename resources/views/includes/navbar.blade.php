<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0 mr-8 text-xl text-gray-100">
                    {{-- <img class="block lg:hidden h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-on-dark.svg" alt="" />
              <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-on-dark.svg" alt="" /> --}}
                    <a href="/">{{ config('app.name', 'Ediary') }}</a>
                </div>
            </div>
            <auth-links>
            </auth-links>
        </div>
    </div>
</nav>