<div class="rounded-2xl bg-blue-50 dark:bg-gray-800 p-8 text-center my-12 border border-blue-100 dark:border-gray-700 shadow-sm">
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Ready to start your own journey?</h3>
    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-lg mx-auto">Join thousands of others who use Ediary to document their lives in a safe, private, and secure space.</p>
    @auth
        <a class="inline-block bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white px-8 py-3 rounded-xl uppercase shadow-md hover:shadow-lg font-bold text-sm transition-all transform hover:scale-105"
           href="/home">
            Start writing Now
        </a>
    @else
        <a class="inline-block bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white px-8 py-3 rounded-xl uppercase shadow-md hover:shadow-lg font-bold text-sm transition-all transform hover:scale-105"
           href="/login">
            Start Writing now
        </a>
    @endauth
</div>
