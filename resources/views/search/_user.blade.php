<div class="search-result my-2 flex items-center rounded-md border p-2 dark:bg-gray-900 dark:text-white">
    <img
        src="{{ $user->profile->image }}"
        alt="Profile picture of {{ $user->username }}"
        class="mr-2 h-24 w-24 rounded-full border"
    />
    <div class="ml-3 flex flex-col">
        <h4 class="text-xl">{{ $user->profile->name }}</h4>
        <p>{{ $user->profile->follower_count }} Followers</p>
        <a
            href="/user/{{ $user->username }}"
            class="mt-2 inline-block rounded-sm bg-blue-600 px-3 py-1 text-center text-xs font-bold text-gray-100 uppercase shadow-sm outline-hidden hover:shadow-md focus:outline-hidden"
        >View Profile</a>
    </div>
</div>
