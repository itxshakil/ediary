@props([
    'canEdit' => false,
    'isFollowing' => false,
    'profile' => null,
])

<div class="h-auto w-full rounded-2xl border border-gray-200/70 bg-gray-200/70 bg-cover p-3 py-4 shadow-[0_1px_2px_rgba(0,0,0,0.05)] md:p-8 lg:block lg:w-1/2 dark:border-gray-700/60 dark:bg-gray-800/60 dark:text-white">
    <div class="flex">
        {{-- Left Image --}}
        <div class="flex flex-col items-center justify-center">
            <img
                id="profileImage"
                src="{{ $profile['image'] }}"
                alt="Profile picture of {{ $profile['user']['username'] }}"
                class="mr-2 h-24 w-24 rounded-full border border-gray-300/70 object-cover shadow-sm dark:border-gray-600/60"
            />

            <p id="uploadingText" class="mt-1 hidden text-xs text-gray-500 dark:text-gray-400">
                Updating... please wait
            </p>

            @if ($canEdit)
                <input
                    id="imageUploader"
                    type="file"
                    accept="image/*"
                    class="mt-2 w-24 cursor-pointer text-xs text-gray-700 focus:outline-none dark:text-gray-200"
                />
            @endif
        </div>

        {{-- Right Info --}}
        <div class="info ml-4 flex-1">
            {{-- Editing Mode --}}
            <div id="editMode" class="hidden">
                <input
                    type="text"
                    id="nameInput"
                    value="{{ $profile['name'] }}"
                    class="w-full rounded-xl border border-gray-200/70 bg-gray-50/80 px-3 py-2 text-sm text-gray-700 shadow-sm focus:border-transparent focus:ring-2 focus:ring-blue-500/50 dark:border-gray-700/60 dark:bg-gray-900/60 dark:text-gray-200"
                />

                <p id="nameError" class="mt-1 hidden text-xs text-red-500 italic"></p>

                <div class="mt-2 flex gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <strong id="followersEdit">{{ $profile['follower_count'] }}</strong> Followers
                    <strong id="followingEdit">{{ $profile['user']['following_count'] }}</strong> Following
                </div>

                <textarea
                    id="bioInput"
                    rows="6"
                    class="mt-3 w-full rounded-xl border border-gray-200/70 bg-gray-50/80 px-3 py-2 text-sm text-gray-700 shadow-sm focus:border-transparent focus:ring-2 focus:ring-blue-500/50 dark:border-gray-700/60 dark:bg-gray-900/60 dark:text-gray-200"
                >{{ $profile['bio'] }}</textarea>
                <p id="bioError" class="mt-1 hidden text-xs text-red-500 italic"></p>

                <div class="mt-4 flex gap-2">
                    <button
                        id="saveBtn"
                        class="rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white uppercase shadow-sm transition hover:shadow-md active:scale-95"
                    >
                        Save
                    </button>

                    <button
                        id="cancelBtn"
                        class="rounded-full bg-gray-500 px-4 py-2 text-xs font-semibold text-white uppercase shadow-sm transition hover:shadow-md active:scale-95"
                    >
                        Cancel
                    </button>
                </div>
            </div>

            {{-- View Mode --}}
            <div id="viewMode">
                <div class="flex items-center gap-2">
                    <div id="displayName" class="text-xl font-semibold">{{ $profile['name'] }}</div>

                    {{-- Follow button --}}
                    @unless ($canEdit)
                        <button
                            id="followBtn"
                            class="px-3 py-1 text-xs rounded-full font-semibold uppercase
                                   transition active:scale-95
                                   {{
                                       $isFollowing
                                       ? 'bg-red-100 text-red-700 hover:bg-red-200'
                                       : 'bg-blue-100 text-blue-700 hover:bg-blue-200'
                                   }}"
                            data-following="{{ $isFollowing ? '1' : '0' }}"
                        >
                            {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                        </button>
                    @endunless
                </div>

                @if ($canEdit)
                    <a
                        id="editBtn"
                        class="ml-1 cursor-pointer text-xs text-blue-600 hover:underline dark:text-blue-400"
                    >
                        Edit Profile
                    </a>
                @endif

                <div class="mt-2 flex gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <strong id="followersView">{{ $profile['follower_count'] }}</strong> Followers
                    <strong id="followingView">{{ $profile['user']['following_count'] }}</strong> Following
                </div>

                <div
                    id="displayBio"
                    class="cursor-pointer pt-3 text-sm leading-relaxed text-gray-700 dark:text-gray-300"
                >
                    {{ $profile['bio'] }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== JS ===================== --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
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

        let username = "{{ $profile['user']['username'] }}";

        // ---- Enable Editing ----
        editBtn?.addEventListener('click', () => {
            viewMode.classList.add('hidden');
            editMode.classList.remove('hidden');
        });

        // ---- Cancel Editing ----
        cancelBtn?.addEventListener('click', () => {
            nameInput.value = originalName;
            bioInput.value = originalBio;

            nameError.classList.add('hidden');
            bioError.classList.add('hidden');

            editMode.classList.add('hidden');
            viewMode.classList.remove('hidden');
        });

        // ---- Save Profile ----
        saveBtn?.addEventListener('click', () => {
            axios
                .post('/profile/' + username, {
                    name: nameInput.value,
                    bio: bioInput.value,
                })
                .then(() => {
                    displayName.textContent = nameInput.value;
                    displayBio.textContent = bioInput.value;

                    originalName = nameInput.value;
                    originalBio = bioInput.value;

                    editMode.classList.add('hidden');
                    viewMode.classList.remove('hidden');

                    flash('Profile Updated Successfully.');
                })
                .catch((err) => {
                    let errors = err.response.data.errors;
                    nameError.textContent = errors?.name?.[0] ?? '';
                    bioError.textContent = errors?.bio?.[0] ?? '';

                    nameError.classList.toggle('hidden', !errors?.name);
                    bioError.classList.toggle('hidden', !errors?.bio);
                });
        });

        // ---- Image Upload Preview + Uploading ----
        let uploader = document.getElementById('imageUploader');
        let imgEl = document.getElementById('profileImage');
        let uploadingText = document.getElementById('uploadingText');

        uploader?.addEventListener('change', (e) => {
            let file = e.target.files[0];
            if (!file) return;

            imgEl.src = URL.createObjectURL(file);
            uploadingText.classList.remove('hidden');

            let form = new FormData();
            form.append('image', file);

            axios
                .post(`/api/users/${username}/avatar`, form)
                .then(() => flash('Image Updated Successfully'))
                .catch(() => flash('Image Upload Failed', 'danger'))
                .finally(() => uploadingText.classList.add('hidden'));
        });

        // ---- Follow / Unfollow ----
        let followBtn = document.getElementById('followBtn');

        followBtn?.addEventListener('click', () => {
            let following = followBtn.dataset.following === '1';

            axios.post(`/follow/${username}`).then(() => {
                let followersView = document.getElementById('followersView');
                let followersEdit = document.getElementById('followersEdit');

                if (following) {
                    followBtn.textContent = 'Follow';
                    followBtn.dataset.following = '0';
                    followersView.textContent--;
                    if (followersEdit) followersEdit.textContent--;
                } else {
                    followBtn.textContent = 'Unfollow';
                    followBtn.dataset.following = '1';
                    followersView.textContent++;
                    if (followersEdit) followersEdit.textContent++;
                }
            });
        });
    });
</script>
