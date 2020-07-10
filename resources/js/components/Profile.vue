<template>
  <div class="w-full h-auto bg-gray-400 lg:block lg:w-1/2 bg-cover rounded-lg py-4 p-2 md:p-8">
    <div class="flex">
      <div class="flex flex-col justify-center">
        <img
          :src="image"
          :alt="'Profile picture of '+user.username"
          class="overflow-hidden rounded-full h-24 w-24 border mr-2"
        />
        <p class="text-xs" v-if="uploading">Updating Please wait...</p>
        <image-upload
          v-if="editable == true"
          class="m-2 ml-0 px-3 py-2 text-sm leading-tight text-gray-700 appearance-none focus:outline-none w-24"
          @loaded="onLoad"
        ></image-upload>
      </div>
      <div class="info" v-if="editing">
        <input
          type="text"
          name="name"
          v-model="name"
          class="px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
        />
        <p
          v-if="errors.name"
          class="text-xs italic text-red-500"
          role="alert"
          v-text="errors.name[0]"
        ></p>
        <div class="flex">
          <strong v-text="follower_count"></strong> Followers
          <strong class="ml-2" v-text="following_count"></strong> Following
        </div>
        <textarea
          name="bio"
          id="bio"
          cols="20"
          rows="10"
          v-model="bio"
          class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
        ></textarea>
        <p
          v-if="errors.bio"
          class="text-xs italic text-red-500"
          role="alert"
          v-text="errors.bio[0]"
        ></p>
        <div class="flex">
          <button
            class="mt-4 bg-blue-100 active:bg-blue-200 text-blue-800 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            @click="save"
          >Save</button>
          <button
            class="mt-4 bg-gray-600 text-gray-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            @click="cancel"
          >Cancel</button>
        </div>
      </div>
      <div class="info" v-else>
        <div class="flex items-center">
          <div class="text-xl mr-2" v-text="name"></div>
          <follow-button
            v-if="editable == false"
            :isFollowing="status"
            :profileUser="user"
            @followed="follower_count ++ "
            @unfollowed="follower_count -- "
          ></follow-button>
        </div>
        <a
          v-if="editable == true"
          class="text-blue-600 outline-none mb-1 ml-1 hover:shadow-md text-xs"
          href="#"
          @click="edit"
        >Edit Profile</a>
        <div class="flex">
          <strong v-text="follower_count"></strong> Followers
          <strong class="ml-2" v-text="following_count"></strong> Following
        </div>
        <div class="pt-2" v-text="bio" @dblclick="edit"></div>
      </div>
    </div>
  </div>
</template>
<script>
import ImageUpload from "./ImageUpload.vue";
import FollowButton from "./FollowButton.vue";
export default {
  props: {
    canEdit: {
      type: Boolean,
      default: false
    },
    isFollowing: {
      type: Boolean,
      default: false
    },
    data: {
      type: Object
    }
  },
  components: { ImageUpload, FollowButton },
  data() {
    return {
      editable: this.canEdit,
      profile: this.data,
      editing: false,
      name: this.data.name,
      bio: this.data.bio,
      image: this.data.image,
      user: this.data.user,
      follower_count: this.data.follower_count,
      following_count: this.data.user.following_count,
      status: this.isFollowing,
      uploading: false,
      errors: {}
    };
  },
  methods: {
    edit() {
      this.editing = true;
    },
    cancel() {
      this.editing = false;
      this.name = this.profile.name;
      this.bio = this.profile.bio;
    },
    save() {
      let username = this.user.username;
      axios
        .post("/profile/" + username, {
          name: this.name,
          bio: this.bio
        })
        .then(response => {
          this.editing = false;
          flash("Profile Updated Succesfully.");
        })
        .catch(err => {
          this.errors = err.response.data.errors;
        });
    },
    onLoad(image) {
      this.image = image.src;
      this.persist(image.file);
    },
    persist(image) {
      this.uploading = true;
      let data = new FormData();
      data.append("image", image);
      axios
        .post(`/api/users/${this.user.username}/avatar`, data)
        .then(() => {
          flash("Image Updated Successfully");
        })
        .catch(err => {
          flash("Image Upload failed", "danger");
        })
        .finally(() => {
          this.uploading = false;
        });
    }
  }
};
</script>
