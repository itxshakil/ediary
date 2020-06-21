<template>
  <div>
    <div
      v-if="!isloggedin"
      class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
    >
      <a
        class="hidden md:block bg-blue-100 active:bg-blue-200 text-blue-800 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
        href="/register"
      >Register</a>
      <a
        class="bg-gray-700 text-gray-100 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
        href="/login"
      >Login</a>
    </div>
    <div v-else>
      <dropdown v-cloak>
        <p
          slot="toggler"
          class="flex text-sm border-2 rounded-full focus:outline-none focus:border-white transition duration-150 ease-in-out text-gray-100"
        >
          <img class="w-10 rounded-full" :src="user.profile.image" alt />
        </p>
        <span slot="items" class="flex flex-col py-1 rounded-md bg-white shadow-xs">
          <a
            :href="'/user/'+user.username"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
          >My Profile</a>
          <a
            href="/home"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
          >Dashboard</a>
          <a
            href="/password/change"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
          >
            Change
            Password
          </a>
          <logout-button
            @loggedout="logout"
            class="block px-4 text-sm py-2 leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
          ></logout-button>
        </span>
      </dropdown>
    </div>
  </div>
</template>
<script>
import logoutButton from "./LogoutButton";
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
    }
  },
  methods: {
    logout() {
      window.location = "/login";
    }
  }
};
</script>