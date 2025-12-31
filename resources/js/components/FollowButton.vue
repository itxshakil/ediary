<template>
  <button
    class="px-2 py-1 rounded-sm outline-hidden focus:outline-hidden mr-2 mb-1 uppercase shadow-sm hover:shadow-md font-bold text-xs"
    :class="status ? 'bg-gray-100 text-gray-900' :'bg-blue-600 text-gray-100'"
    @click="toggle"
    v-text="btnText"
  ></button>
</template>
<script>
export default {
  props: ["profileUser", "isFollowing"],
  data() {
    return {
      status: this.isFollowing,
    };
  },
  computed: {
    btnText() {
      return this.status ? "Following" : "Follow";
    }
  },
  methods: {
    toggle() {
      axios
        .post(`/profile/${this.profileUser.username}/follow`)
        .then(response => {
          this.status = !this.status;

          this.status ? this.$emit("followed") : this.$emit("unfollowed");
        })
        .catch(err => {
          if (err.response.status == 401) {
            window.location = "/login";
          }
        });
    }
  }
};
</script>