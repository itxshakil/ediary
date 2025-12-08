@props([
    'canEdit' => false,
    'isFollowing' => false,
    'profile' => null,
])

<div class="w-full h-auto bg-gray-200/70 dark:bg-gray-800/60 dark:text-white
            lg:block lg:w-1/2 bg-cover
            rounded-2xl py-4 p-3 md:p-8
            border border-gray-200/70 dark:border-gray-700/60
            shadow-[0_1px_2px_rgba(0,0,0,0.05)]">

    <div class="flex">

        {{-- Left Image --}}
        <div class="flex flex-col justify-center items-center">
            <img
                id="profileImage"
                src="{{ $profile['image'] }}"
                alt="Profile picture of {{ $profile['user']['username'] }}"
                class="rounded-full h-24 w-24 border border-gray-300/70 dark:border-gray-600/60
                       shadow-sm mr-2 object-cover"
            />

            <p id="uploadingText" class="text-xs text-gray-500 dark:text-gray-400 hidden mt-1">
                Updating... please wait
            </p>

            @if($canEdit)
                <input
                    id="imageUploader"
                    type="file"
                    accept="image/*"
                    class="mt-2 w-24 text-xs text-gray-700 dark:text-gray-200
                           focus:outline-none cursor-pointer"
                >
            @endif
        </div>

        {{-- Right Info --}}
        <div class="info flex-1 ml-4">

            {{-- Editing Mode --}}
            <div id="editMode" class="hidden">

                <input
                    type="text"
                    id="nameInput"
                    value="{{ $profile['name'] }}"
                    class="w-full px-3 py-2 text-sm
                           text-gray-700 dark:text-gray-200
                           bg-gray-50/80 dark:bg-gray-900/60
                           border border-gray-200/70 dark:border-gray-700/60
                           rounded-xl shadow-sm
                           focus:ring-2 focus:ring-blue-500/50 focus:border-transparent"
                />

                <p id="nameError" class="text-xs italic text-red-500 hidden mt-1"></p>

                <div class="flex mt-2 text-sm text-gray-600 dark:text-gray-400 gap-2">
                    <strong id="followersEdit">{{ $profile['follower_count'] }}</strong> Followers
                    <strong id="followingEdit">{{ $profile['user']['following_count'] }}</strong> Following
                </div>

                <textarea
                    id="bioInput"
                    rows="6"
                    class="w-full mt-3 px-3 py-2 text-sm
                           text-gray-700 dark:text-gray-200
                           bg-gray-50/80 dark:bg-gray-900/60
                           border border-gray-200/70 dark:border-gray-700/60
                           rounded-xl shadow-sm
                           focus:ring-2 focus:ring-blue-500/50 focus:border-transparent"
                >{{ $profile['bio'] }}</textarea>

                <p id="bioError" class="text-xs italic text-red-500 hidden mt-1"></p>

                <div class="flex mt-4 gap-2">
                    <button
                        id="saveBtn"
                        class="bg-blue-600 text-white px-4 py-2
                               rounded-full shadow-sm hover:shadow-md
                               font-semibold text-xs uppercase
                               transition active:scale-95"
                    >
                        Save
                    </button>

                    <button
                        id="cancelBtn"
                        class="bg-gray-500 text-white px-4 py-2
                               rounded-full shadow-sm hover:shadow-md
                               font-semibold text-xs uppercase
                               transition active:scale-95"
                    >
                        Cancel
                    </button>
                </div>
            </div>

            {{-- View Mode --}}
            <div id="viewMode">

                <div class="flex items-center gap-2">
                    <div id="displayName" class="text-xl font-semibold">
                        {{ $profile['name'] }}
                    </div>

                    {{-- Follow button --}}
                    @unless($canEdit)
                        <button
                            id="followBtn"
                            class="px-3 py-1 text-xs rounded-full font-semibold uppercase
                                   transition active:scale-95
                                   {{ $isFollowing
                                        ? 'bg-red-100 text-red-700 hover:bg-red-200'
                                        : 'bg-blue-100 text-blue-700 hover:bg-blue-200' }}"
                            data-following="{{ $isFollowing ? '1' : '0' }}"
                        >
                            {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                        </button>
                    @endunless
                </div>

                @if($canEdit)
                    <a
                        id="editBtn"
                        class="text-blue-600 dark:text-blue-400
                               hover:underline text-xs cursor-pointer ml-1"
                    >
                        Edit Profile
                    </a>
                @endif

                <div class="flex mt-2 text-sm text-gray-600 dark:text-gray-400 gap-2">
                    <strong id="followersView">{{ $profile['follower_count'] }}</strong> Followers
                    <strong id="followingView">{{ $profile['user']['following_count'] }}</strong> Following
                </div>

                <div
                    id="displayBio"
                    class="pt-3 text-sm leading-relaxed text-gray-700 dark:text-gray-300 cursor-pointer"
                >
                    {{ $profile['bio'] }}
                </div>

            </div>

        </div>
    </div>
</div>



{{-- ===================== JS ===================== --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {

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

        let username = "{{ $profile['user']['username'] }}";

        // ---- Enable Editing ----
        editBtn?.addEventListener("click", () => {
            viewMode.classList.add("hidden");
            editMode.classList.remove("hidden");
        });

        // ---- Cancel Editing ----
        cancelBtn?.addEventListener("click", () => {
            nameInput.value = originalName;
            bioInput.value = originalBio;

            nameError.classList.add("hidden");
            bioError.classList.add("hidden");

            editMode.classList.add("hidden");
            viewMode.classList.remove("hidden");
        });

        // ---- Save Profile ----
        saveBtn?.addEventListener("click", () => {
            axios.post("/profile/" + username, {
                name: nameInput.value,
                bio: bioInput.value
            })
                .then(() => {
                    displayName.textContent = nameInput.value;
                    displayBio.textContent = bioInput.value;

                    originalName = nameInput.value;
                    originalBio = bioInput.value;

                    editMode.classList.add("hidden");
                    viewMode.classList.remove("hidden");

                    flash("Profile Updated Successfully.");
                })
                .catch(err => {
                    let errors = err.response.data.errors;
                    nameError.textContent = errors?.name?.[0] ?? "";
                    bioError.textContent = errors?.bio?.[0] ?? "";

                    nameError.classList.toggle("hidden", !errors?.name);
                    bioError.classList.toggle("hidden", !errors?.bio);
                });
        });

        // ---- Image Upload Preview + Uploading ----
        let uploader = document.getElementById("imageUploader");
        let imgEl = document.getElementById("profileImage");
        let uploadingText = document.getElementById("uploadingText");

        uploader?.addEventListener("change", (e) => {
            let file = e.target.files[0];
            if (!file) return;

            imgEl.src = URL.createObjectURL(file);
            uploadingText.classList.remove("hidden");

            let form = new FormData();
            form.append("image", file);

            axios.post(`/api/users/${username}/avatar`, form)
                .then(() => flash("Image Updated Successfully"))
                .catch(() => flash("Image Upload Failed", "danger"))
                .finally(() => uploadingText.classList.add("hidden"));
        });

        // ---- Follow / Unfollow ----
        let followBtn = document.getElementById("followBtn");

        followBtn?.addEventListener("click", () => {
            let following = followBtn.dataset.following === "1";

            axios.post(`/follow/${username}`)
                .then(() => {
                    let followersView = document.getElementById("followersView");
                    let followersEdit = document.getElementById("followersEdit");

                    if (following) {
                        followBtn.textContent = "Follow";
                        followBtn.dataset.following = "0";
                        followersView.textContent--;
                        if (followersEdit) followersEdit.textContent--;
                    } else {
                        followBtn.textContent = "Unfollow";
                        followBtn.dataset.following = "1";
                        followersView.textContent++;
                        if (followersEdit) followersEdit.textContent++;
                    }
                });
        });

    });
</script>
