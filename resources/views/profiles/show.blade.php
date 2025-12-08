@extends('layouts.app')

@section('title', $profile->name . "'s Profile | E-diary")

@push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "ProfilePage",
            "mainEntity": {
                "@type": "Person",
                "name": "{{ $profile->name }}",
                "alternateName": "{{ $profile->user->username }}",
                "description": "{{ $profile->bio }}",
                "image": "{{ $profile->image }}",
                "interactionStatistic": [
                    {
                        "@type": "InteractionCounter",
                        "interactionType": "https://schema.org/FollowAction",
                        "userInteractionCount": "{{ $profile->follower_count }}"
                    },
                    {
                        "@type": "InteractionCounter",
                        "interactionType": "https://schema.org/WriteAction",
                        "userInteractionCount": "{{ $profile->post_count ?? 0 }}"
                    }
                ]
            }
        }
    </script>
@endpush

@push('meta')
    <link rel="canonical" href="{{ request()->fullUrl() }}" />
    <meta name="description" content="{{ $profile->name }}'s profile — {{ $profile->bio }}" />
    <meta property="og:title" content="{{ $profile->name }}'s Profile" />
    <meta property="og:description" content="{{ $profile->bio }}" />
    <meta property="og:image" content="{{ $profile->image }}" />
    <meta name="twitter:card" content="summary" />
@endpush

@section('content')
    <div class="min-h-screen bg-linear-to-br from-gray-50/80 to-gray-100
            dark:from-gray-900/80 dark:to-gray-800">

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="max-w-4xl mx-auto">

                <div class="bg-white/90 dark:bg-gray-800/70
                        rounded-2xl
                        border border-gray-200/70 dark:border-gray-700/60
                        shadow-[0_1px_2px_rgba(0,0,0,0.05)]
                        overflow-hidden">

                    {{-- Cover --}}
                    <div class="h-32 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>

                    <div class="p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row gap-6">

                            {{-- Avatar --}}
                            <div class="flex-shrink-0 -mt-16 sm:-mt-20">
                                <div class="relative">
                                    <img
                                        id="profileImage"
                                        src="{{ $profile->image }}"
                                        alt="Profile picture of {{ $profile->user->username }}"
                                        class="w-32 h-32 sm:w-40 sm:h-40
                                           rounded-full
                                           border-4 border-white dark:border-gray-800
                                           object-cover
                                           shadow-xl"
                                    />

                                    @can('update', $profile)
                                        <label
                                            for="imageUploader"
                                            class="absolute bottom-2 right-2
                                               w-10 h-10
                                               rounded-full
                                               bg-blue-600 hover:bg-blue-700
                                               flex items-center justify-center
                                               shadow-lg
                                               transition active:scale-95 cursor-pointer"
                                        >
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </label>

                                        <input id="imageUploader" type="file" accept="image/*" class="hidden" />

                                        <p id="uploadingText"
                                           class="absolute -bottom-6 left-1/2 -translate-x-1/2
                                              text-xs text-gray-500 dark:text-gray-400
                                              hidden whitespace-nowrap">
                                            Updating...
                                        </p>
                                    @endcan
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">

                                {{-- View --}}
                                <div id="viewMode">
                                    <div class="flex items-start justify-between gap-4">

                                        <div class="flex-1 min-w-0">
                                            <h1 id="displayName"
                                                class="text-2xl sm:text-3xl font-semibold
                                                   text-gray-900 dark:text-white truncate">
                                                {{ $profile->name }}
                                            </h1>

                                            <p class="text-gray-500 dark:text-gray-400 mt-1">
                                                {{ '@'.$profile->user->username }}
                                            </p>

                                            {{-- Stats --}}
                                            <div class="flex flex-wrap items-center gap-6 mt-4 text-sm">
                                                <div class="flex items-center gap-2">
                                                <span id="followersView"
                                                      class="font-semibold text-gray-900 dark:text-white">
                                                    {{ number_format($profile->follower_count) }}
                                                </span>
                                                    <span class="text-gray-500 dark:text-gray-400">Followers</span>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                <span id="followingView"
                                                      class="font-semibold text-gray-900 dark:text-white">
                                                    {{ number_format($profile->user->following_count) }}
                                                </span>
                                                    <span class="text-gray-500 dark:text-gray-400">Following</span>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                <span class="font-semibold text-gray-900 dark:text-white">
                                                    {{ number_format($profile->post_count ?? 0) }}
                                                </span>
                                                    <span class="text-gray-500 dark:text-gray-400">Entries</span>
                                                </div>
                                            </div>

                                            <p id="displayBio"
                                               class="mt-4 text-gray-700 dark:text-gray-300
                                                  leading-relaxed text-sm">
                                                {{ $profile->bio ?: 'No bio yet.' }}
                                            </p>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex flex-col gap-2">
                                            @can('update', $profile)
                                                <button
                                                    id="editBtn"
                                                    class="inline-flex items-center gap-2
                                                       px-4 py-2
                                                       bg-blue-600 hover:bg-blue-700
                                                       text-white text-sm font-medium
                                                       rounded-full
                                                       transition active:scale-95"
                                                >
                                                    Edit Profile
                                                </button>
                                            @else
                                                @auth
                                                    <x-button.primary
                                                        id="followBtn"
                                                        data-following="{{ $isFollowing ? '1' : '0' }}"
                                                        class="{{ $isFollowing ? 'opacity-0 pointer-events-none h-0' : '' }}"
                                                    >
                                                        Follow
                                                    </x-button.primary>

                                                    <x-button.secondary
                                                        id="followingBtn"
                                                        class="{{ $isFollowing ? '' : 'opacity-0 pointer-events-none h-0' }}"
                                                    >
                                                        Following
                                                    </x-button.secondary>
                                                @endauth
                                            @endcan
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit --}}
                                <div id="editMode" class="hidden">
                                    <div class="space-y-4">

                                        <input
                                            id="nameInput"
                                            type="text"
                                            placeholder="Name"
                                            value="{{ $profile->name }}"
                                            class="w-full px-4 py-2
                                               bg-gray-50/80 dark:bg-gray-900/60
                                               border border-gray-200/70 dark:border-gray-700/60
                                               rounded-xl
                                               text-sm text-gray-900 dark:text-white
                                               focus:ring-2 focus:ring-blue-500/50 focus:border-transparent"
                                        />
                                        <p id="nameError" class="text-xs text-red-500 hidden"></p>

                                        <textarea
                                            id="bioInput"
                                            rows="4"
                                            class="w-full px-4 py-2
                                               bg-gray-50/80 dark:bg-gray-900/60
                                               border border-gray-200/70 dark:border-gray-700/60
                                               rounded-xl
                                               text-sm text-gray-900 dark:text-white
                                               focus:ring-2 focus:ring-blue-500/50 focus:border-transparent resize-none"
                                        >{{ $profile->bio }}</textarea>
                                        <p id="bioError" class="text-xs text-red-500 hidden"></p>

                                        <div class="flex gap-3">
                                            <button id="saveBtn"
                                                    class="px-6 py-2
                                                       bg-blue-600 hover:bg-blue-700
                                                       text-white text-sm font-medium
                                                       rounded-full
                                                       transition active:scale-95">
                                                Save
                                            </button>
                                            <button id="cancelBtn"
                                                    class="px-6 py-2
                                                       bg-gray-200 dark:bg-gray-700
                                                       text-gray-700 dark:text-gray-300
                                                       rounded-full
                                                       transition active:scale-95">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Public Entries --}}
                <div class="mt-8 bg-white/90 dark:bg-gray-800/70
                        rounded-2xl
                        border border-gray-200/70 dark:border-gray-700/60
                        shadow-[0_1px_2px_rgba(0,0,0,0.05)]
                        p-6 sm:p-8">

                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        Public Entries
                    </h2>

                    <div class="text-center py-16">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            Coming Soon
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Public entries will appear here when published.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const followBtn = document.getElementById("followBtn");
        const followingBtn = document.getElementById("followingBtn");
        const followersView = document.getElementById("followersView");
        const username = "{{ $profile->user->username }}";

        followBtn?.addEventListener("click", async () => {
            try {
                const res = await fetch(`/follow/${username}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                });

                if (!res.ok) return;

                // UI swap (Apple style)
                followBtn.classList.add("opacity-0",  "pointer-events-none", "h-0");
                followingBtn.classList.remove("opacity-0",  "pointer-events-none", "h-0");

                // Count update
                followersView.textContent =
                    Number(followersView.textContent.replace(/,/g, "")) + 1;
            } catch (e) {
                console.error(e);
            }
        });

        followingBtn?.addEventListener("click", async () => {
            try {
                const res = await fetch(`/follow/${username}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                });

                if (!res.ok) return;

                followingBtn.classList.add("opacity-0",  "pointer-events-none", "h-0");
                followBtn.classList.remove("opacity-0",  "pointer-events-none", "h-0");

                followersView.textContent =
                    Number(followersView.textContent.replace(/,/g, "")) - 1;
            } catch (e) {
                console.error(e);
            }
        });
    </script>


    <script>
        let editMode = document.getElementById("editMode");
        let viewMode = document.getElementById("viewMode");
        let editBtn = document.getElementById("editBtn");
        let saveBtn = document.getElementById("saveBtn");
        let cancelBtn = document.getElementById("cancelBtn");
        let nameInput = document.getElementById("nameInput");
        let bioInput = document.getElementById("bioInput");
        let displayName = document.getElementById("displayName");
        let displayBio = document.getElementById("displayBio");
        let nameError = document.getElementById("nameError");
        let bioError = document.getElementById("bioError");
        let originalName = nameInput?.value;
        let originalBio = bioInput?.value;

        // Enable editing
        editBtn?.addEventListener("click", () => {
            viewMode.classList.add("hidden");
            editMode.classList.remove("hidden");
        });

        // Cancel editing
        cancelBtn?.addEventListener("click", () => {
            nameInput.value = originalName;
            bioInput.value = originalBio;
            nameError.classList.add("hidden");
            bioError.classList.add("hidden");
            editMode.classList.add("hidden");
            viewMode.classList.remove("hidden");
        });

        // Save profile
        saveBtn?.addEventListener("click", async () => {
            try {
                const response = await fetch(`/profile/${username}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: nameInput.value,
                        bio: bioInput.value
                    })
                });

                if (response.ok) {
                    displayName.textContent = nameInput.value;
                    displayBio.textContent = bioInput.value;
                    originalName = nameInput.value;
                    originalBio = bioInput.value;
                    editMode.classList.add("hidden");
                    viewMode.classList.remove("hidden");

                    // Show success notification
                    showNotification('Profile updated successfully!', 'success');
                } else {
                    const data = await response.json();
                    const errors = data.errors || {};
                    nameError.textContent = errors.name?.[0] ?? "";
                    bioError.textContent = errors.bio?.[0] ?? "";
                    nameError.classList.toggle("hidden", !errors.name);
                    bioError.classList.toggle("hidden", !errors.bio);
                }
            } catch (error) {
                console.error('Profile update error:', error);
                showNotification('Failed to update profile', 'error');
            }
        });

        // Image upload
        const uploader = document.getElementById("imageUploader");
        const imgEl = document.getElementById("profileImage");
        const uploadingText = document.getElementById("uploadingText");

        uploader?.addEventListener("change", async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            imgEl.src = URL.createObjectURL(file);
            uploadingText.classList.remove("hidden");

            const formData = new FormData();
            formData.append("image", file);

            try {
                const response = await fetch(`/api/users/${username}/avatar`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                if (response.ok) {
                    showNotification('Profile picture updated!', 'success');
                } else {
                    showNotification('Image upload failed', 'error');
                }
            } catch (error) {
                showNotification('Image upload failed', 'error');
            } finally {
                uploadingText.classList.add("hidden");
            }
        });

        function showNotification(message, type = 'success') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500'
            };

            const notification = document.createElement('div');
            notification.className = `fixed top-6 right-6 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-slide-down`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
@endsection
