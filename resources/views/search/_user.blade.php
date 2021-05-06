<div class="my-2 p-2 rounded border flex items-center search-result">
    <img src="{{$user->profile->image}}" alt="Profile picture of {{$user->username}}"
        class="rounded-full h-24 w-24 border mr-2">
    <div class="ml-3 flex flex-col">
        <h4 class="text-xl">{{$user->profile->name}}</h4>
        <p>{{$user->profile->follower_count}} Followers</p>
        <a href="/user/{{$user->username}}"
            class="inline-block text-center bg-blue-600 text-gray-100 py-1 px-2 rounded outline-none focus:outline-none mt-2 uppercase shadow hover:shadow-md font-bold text-xs">View
            Profile</a>
    </div>
</div>