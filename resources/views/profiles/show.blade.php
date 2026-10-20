@extends('layouts.app')
@section('robots', 'noindex, follow')

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
                        "userInteractionCount": "{{ $publicEntries->total() }}"
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
    <div class="min-h-screen bg-linear-to-br from-gray-50/80 to-gray-100 dark:from-gray-900/80 dark:to-gray-800">
        <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl">
                <div class="shadow-card overflow-hidden rounded-2xl border border-gray-200/70 bg-white/90 dark:border-gray-700/60 dark:bg-gray-800/70">
                    {{-- Cover --}}
                    <div class="from-primary-500 h-32 bg-gradient-to-r via-purple-500 to-pink-500"></div>

                    <div class="p-6 sm:p-8">
                        <div class="flex flex-col gap-6 sm:flex-row">
                            {{-- Avatar --}}
                            <div class="-mt-16 flex-shrink-0 sm:-mt-20">
                                <div class="relative">
                                    <img
                                        id="profileImage"
                                        src="{{ $profile->image }}"
                                        alt="Profile picture of {{ $profile->user->username }}"
                                        class="h-32 w-32 rounded-full border-4 border-white object-cover shadow-xl sm:h-40 sm:w-40 dark:border-gray-800"
                                    />

                                    @can('update', $profile)
                                        <label
                                            for="imageUploader"
                                            class="bg-primary-600 hover:bg-primary-700 absolute right-2 bottom-2 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full shadow-lg transition active:scale-95"
                                        >
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </label>

                                        <input id="imageUploader" type="file" accept="image/*" class="hidden" />

                                        <p
                                            id="uploadingText"
                                            class="absolute -bottom-6 left-1/2 hidden -translate-x-1/2 text-xs whitespace-nowrap text-gray-500 dark:text-gray-400"
                                        >
                                            Updating...
                                        </p>
                                    @endcan
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="min-w-0 flex-1">
                                {{-- View --}}
                                <div id="viewMode">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center gap-3">
                                                <h1
                                                    id="displayName"
                                                    class="truncate text-2xl font-semibold text-gray-900 sm:text-3xl dark:text-white"
                                                >
                                                    {{ $profile->name }}
                                                </h1>

                                                @can('update', $profile)
                                                    <x-button id="editBtn"> Edit Profile </x-button>
                                                @endcan
                                            </div>

                                            <p class="mt-1 text-gray-500 dark:text-gray-400">
                                                {{ '@'.$profile->user->username }}
                                            </p>

                                            {{-- Stats --}}
                                            <div class="mt-4 flex flex-wrap items-center gap-6 text-sm">
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        id="followersView"
                                                        class="font-semibold text-gray-900 dark:text-white"
                                                    >
                                                        {{ number_format($profile->follower_count) }}
                                                    </span>
                                                    <span class="text-gray-500 dark:text-gray-400">Followers</span>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    <span
                                                        id="followingView"
                                                        class="font-semibold text-gray-900 dark:text-white"
                                                    >
                                                        {{ number_format($profile->user->following_count) }}
                                                    </span>
                                                    <span class="text-gray-500 dark:text-gray-400">Following</span>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    <span class="font-semibold text-gray-900 dark:text-white">
                                                        {{ number_format($publicEntries->total()) }}
                                                    </span>
                                                    <span class="text-gray-500 dark:text-gray-400">Public entries</span>
                                                </div>
                                            </div>

                                            <p
                                                id="displayBio"
                                                class="mt-4 text-sm leading-relaxed text-gray-700 dark:text-gray-300"
                                            >
                                                {{ $profile->bio ?: 'No bio yet.' }}
                                            </p>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex flex-col gap-2">
                                            @can('update', $profile)
                                            @else
                                                @auth
                                                    <x-button
                                                        id="followBtn"
                                                        data-following="{{ $isFollowing ? '1' : '0' }}"
                                                        class="{{ $isFollowing ? 'opacity-0 pointer-events-none h-0' : '' }}"
                                                    >
                                                        Follow
                                                    </x-button>

                                                    <x-button
                                                        variant="secondary"
                                                        id="followingBtn"
                                                        class="{{ $isFollowing ? '' : 'opacity-0 pointer-events-none h-0' }}"
                                                    >
                                                        Following
                                                    </x-button>
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
                                            class="field"
                                        />
                                        <p id="nameError" class="hidden text-xs text-red-500"></p>

                                        <textarea
                                            id="bioInput"
                                            rows="4"
                                            class="field resize-none"
                                        >{{ $profile->bio }}</textarea>
                                        <p id="bioError" class="hidden text-xs text-red-500"></p>

                                        <div class="flex gap-3">
                                            <x-button id="saveBtn"> Save </x-button>
                                            <x-button variant="secondary" id="cancelBtn"> Cancel </x-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Public Entries --}}
                <section class="mt-8" aria-labelledby="public-entries-heading">
                    <h2 id="public-entries-heading" class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                        Public entries
                    </h2>

                    <div class="space-y-4">
                        @forelse ($publicEntries as $entry)
                            <x-diary-card :entry="$entry" :show-owner="true" />
                        @empty
                            <x-empty-state
                                title="No public entries yet"
                                body="Entries are private by default. Anything shared publicly will show up here."
                            />
                        @endforelse
                    </div>

                    <x-diary-paginator :collection="$publicEntries" />
                </section>
            </div>
        </div>
    </div>

    <script>
        const followBtn = document.getElementById('followBtn');
        const followingBtn = document.getElementById('followingBtn');
        const followersView = document.getElementById('followersView');
        const username = "{{ $profile->user->username }}";

        followBtn?.addEventListener('click', async () => {
            try {
                const res = await fetch(`/follow/${username}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        Accept: 'application/json',
                    },
                });

                if (!res.ok) return;

                // UI swap (Apple style)
                followBtn.classList.add('opacity-0', 'pointer-events-none', 'h-0');
                followingBtn.classList.remove('opacity-0', 'pointer-events-none', 'h-0');

                // Count update
                followersView.textContent = Number(followersView.textContent.replace(/,/g, '')) + 1;
            } catch (e) {
                console.error(e);
            }
        });

        followingBtn?.addEventListener('click', async () => {
            try {
                const res = await fetch(`/follow/${username}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        Accept: 'application/json',
                    },
                });

                if (!res.ok) return;

                followingBtn.classList.add('opacity-0', 'pointer-events-none', 'h-0');
                followBtn.classList.remove('opacity-0', 'pointer-events-none', 'h-0');

                followersView.textContent = Number(followersView.textContent.replace(/,/g, '')) - 1;
            } catch (e) {
                console.error(e);
            }
        });
    </script>

    <script>
        let editMode = document.getElementById('editMode');
        let viewMode = document.getElementById('viewMode');
        let editBtn = document.getElementById('editBtn');
        let saveBtn = document.getElementById('saveBtn');
        let cancelBtn = document.getElementById('cancelBtn');
        let nameInput = document.getElementById('nameInput');
        let bioInput = document.getElementById('bioInput');
        let displayName = document.getElementById('displayName');
        let displayBio = document.getElementById('displayBio');
        let nameError = document.getElementById('nameError');
        let bioError = document.getElementById('bioError');
        let originalName = nameInput?.value;
        let originalBio = bioInput?.value;

        // Enable editing
        editBtn?.addEventListener('click', () => {
            viewMode.classList.add('hidden');
            editMode.classList.remove('hidden');
        });

        // Cancel editing
        cancelBtn?.addEventListener('click', () => {
            nameInput.value = originalName;
            bioInput.value = originalBio;
            nameError.classList.add('hidden');
            bioError.classList.add('hidden');
            editMode.classList.add('hidden');
            viewMode.classList.remove('hidden');
        });

        // Save profile
        saveBtn?.addEventListener('click', async () => {
            try {
                const response = await fetch(`/profile/${username}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({
                        name: nameInput.value,
                        bio: bioInput.value,
                    }),
                });

                if (response.ok) {
                    displayName.textContent = nameInput.value;
                    displayBio.textContent = bioInput.value;
                    originalName = nameInput.value;
                    originalBio = bioInput.value;
                    editMode.classList.add('hidden');
                    viewMode.classList.remove('hidden');

                    // Show success notification
                    showNotification('Profile updated successfully!', 'success');
                } else {
                    const data = await response.json();
                    const errors = data.errors || {};
                    nameError.textContent = errors.name?.[0] ?? '';
                    bioError.textContent = errors.bio?.[0] ?? '';
                    nameError.classList.toggle('hidden', !errors.name);
                    bioError.classList.toggle('hidden', !errors.bio);
                }
            } catch (error) {
                console.error('Profile update error:', error);
                showNotification('Failed to update profile', 'error');
            }
        });

        // Image upload
        const uploader = document.getElementById('imageUploader');
        const imgEl = document.getElementById('profileImage');
        const uploadingText = document.getElementById('uploadingText');

        uploader?.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            imgEl.src = URL.createObjectURL(file);
            uploadingText.classList.remove('hidden');

            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch(`/api/users/${username}/avatar`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData,
                });

                if (response.ok) {
                    showNotification('Profile picture updated!', 'success');
                } else {
                    showNotification('Image upload failed', 'error');
                }
            } catch (error) {
                showNotification('Image upload failed', 'error');
            } finally {
                uploadingText.classList.add('hidden');
            }
        });

        function showNotification(message, type = 'success') {
            window.toast?.({ type, message });
        }
    </script>
@endsection
