<template>
  <div class="w-full h-auto bg-gray-400 lg:block lg:w-1/2 bg-cover rounded-lg p-8">
    <div class="flex">
      <img :src="profile.image" :alt="profile.image" class="rounded-full h-16 w-16 border mr-2" />
      <div class="info">
        <div class="flex items-center">
          <div v-if="editing == false" class="text-xl mr-2" v-text="name"></div>
          <div v-else>
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
          </div>
          <a
            class="bg-gray-700 text-gray-100 font-normal px-2 py-1 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            href="#"
            v-if="editable == false"
          >Follow</a>
          <a
            v-if="editable == true && editing ==false"
            class="bg-gray-700 text-gray-100 font-normal px-2 py-1 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            href="#"
            @click="edit"
          >Edit</a>
        </div>
        <div class="flex">
          <span class="mr-2">212 Followers</span>
          <span>212 Following</span>
        </div>
        <div v-if="editing == false" class="pt-2" v-text="bio" @dblclick="edit"></div>
        <div v-else>
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
        </div>
      </div>
    </div>
    <div class="flex" v-if="editing == true">
      <button
        class="mt-4 bg-blue-100 active:bg-blue-200 text-blue-800 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
        @click="save"
      >Save</button>
      <button
        class="mt-4 bg-gray-600 text-gray-100 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
        @click="cancel"
      >Cancel</button>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    canEdit: {
      type: Boolean,
      default: false
    },
    data: {
      type: Object
    }
  },
  data() {
    return {
      editable: this.canEdit,
      profile: this.data,
      editing: false,
      name: this.data.name,
      bio: this.data.bio,
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
      let username = this.$root.user.username;
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
    }
  }
};
</script>
