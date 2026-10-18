<div class="border-primary-100 bg-primary-50 my-12 rounded-2xl border p-8 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <h3 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Ready to start your own journey?</h3>
    <p class="mx-auto mb-8 max-w-lg text-gray-600 dark:text-gray-400">
        Start a private journal in seconds with just your email. Free, unlimited, and it works offline.
    </p>
    @auth
        <a
            class="bg-primary-600 hover:bg-primary-700 active:bg-primary-800 inline-block transform rounded-xl px-8 py-3 text-sm font-bold text-white uppercase shadow-md transition-all hover:scale-105 hover:shadow-lg"
            href="/home"
        >
            Start writing Now
        </a>
    @else
        <a
            class="bg-primary-600 hover:bg-primary-700 active:bg-primary-800 inline-block transform rounded-xl px-8 py-3 text-sm font-bold text-white uppercase shadow-md transition-all hover:scale-105 hover:shadow-lg"
            href="{{ route('register') }}"
        >
            Start Writing now
        </a>
    @endauth
</div>
