<div class="my-12 rounded-2xl border border-blue-100 bg-blue-50 p-8 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <h3 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Ready to start your own journey?</h3>
    <p class="mx-auto mb-8 max-w-lg text-gray-600 dark:text-gray-400">
        Join thousands of others who use Ediary to document their lives in a safe, private, and secure space.
    </p>
    @auth
        <a
            class="inline-block transform rounded-xl bg-blue-600 px-8 py-3 text-sm font-bold text-white uppercase shadow-md transition-all hover:scale-105 hover:bg-blue-700 hover:shadow-lg active:bg-blue-800"
            href="/home"
        >
            Start writing Now
        </a>
    @else
        <a
            class="inline-block transform rounded-xl bg-blue-600 px-8 py-3 text-sm font-bold text-white uppercase shadow-md transition-all hover:scale-105 hover:bg-blue-700 hover:shadow-lg active:bg-blue-800"
            href="/login"
        >
            Start Writing now
        </a>
    @endauth
</div>
