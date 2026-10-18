<div class="search-result my-2 flex items-center rounded-xl border p-2 dark:bg-gray-900 dark:text-white">
    <img
        src="{{ $user->profile->image }}"
        alt="Profile picture of {{ $user->username }}"
        class="mr-2 h-24 w-24 rounded-full border"
    />
    <div class="ml-3 flex flex-col">
        <h4 class="text-xl">{{ $user->profile->name }}</h4>
        <p>{{ $user->profile->follower_count }} Followers</p>
        <x-button size="sm" href="/user/{{ $user->username }}" class="mt-2">View Profile</x-button>
    </div>
</div>
