<div class="border-primary-100 bg-primary-50 my-12 rounded-2xl border p-8 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <h3 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Ready to start your own journey?</h3>
    <p class="mx-auto mb-8 max-w-lg text-gray-600 dark:text-gray-400">
        Start a private journal in seconds with just your email. Free, unlimited, and it works offline.
    </p>
    @auth
        <x-button size="lg" href="/home"> Write today's entry </x-button>
    @else
        <x-button size="lg" href="{{ route('register') }}"> Start writing for free </x-button>
    @endauth
</div>
