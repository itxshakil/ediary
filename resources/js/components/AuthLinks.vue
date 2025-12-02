<template>
  <div v-if="!isloggedin" class="flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
    <a
      class="hidden md:block bg-blue-100 active:bg-blue-200 text-blue-800 px-4 py-2 rounded outline-none focus:outline-none mr-2 uppercase shadow hover:shadow-md font-bold text-xs"
      href="/register"
    >Register</a>
    <a
      class="bg-gray-700 text-gray-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 uppercase shadow hover:shadow-md font-bold text-xs"
      href="/login"
    >Login</a>
  </div>
  <dropdown v-cloak v-else>
    <img
      slot="toggler"
      class="flex text-sm border-2 focus:outline-none focus:border-white transition duration-150 ease-in-out text-gray-100 w-10 rounded-full"
      :src="user.profile.image"
      :alt="user.username"
    />

    <span slot="items" class="flex flex-col py-1 rounded-md bg-white shadow-xs">
      <a
        v-if="!isEmailVerified"
        href="/email/verify"
        class="block px-4 py-2 text-sm leading-5 text-red-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
      >Verify Email Address</a>
      <a
        :href="'/user/' + user.username"
        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
      >My Profile</a>
      <a
        href="/home"
        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
      >Dashboard</a>
      <a
        href="/password/change"
        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
      >Change Password</a>
      <a
        href="/settings"
        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
      >Settings</a>
      <logout-button
        @loggedout="logout"
        class="block px-4 text-sm py-2 leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
      ></logout-button>
    </span>
  </dropdown>
</template>
<script>
import logoutButton from "./LogoutButton.vue";
export default {
  components: { logoutButton },
  data() {
    return {
      user: this.$root.user
    };
  },
  computed: {
    isloggedin() {
      return !!this.user;
    },
    isEmailVerified() {
      if (this.isloggedin) {
        return !!this.user.email_verified_at;
      }
      return false;
    }
  },
  methods: {
    logout() {
      window.location = "/login";
    }
  }
};
</script>
