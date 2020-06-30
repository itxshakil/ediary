<template>
  <form method="POST" @submit.prevent="login">
    <div class="mb-4">
      <label class="block mb-2 text-sm font-bold text-gray-700" for="username">Username</label>
      <input
        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
        :class="errors.username ? 'border-red-500' :null"
        type="text"
        id="username"
        name="username"
        autocomplete="username"
        placeholder="john.doe"
        v-model="username"
        required
        autofocus
      />
      <p
        v-if="errors.username"
        class="text-xs italic text-red-500"
        role="alert"
        v-text="errors.username[0]"
      ></p>
    </div>
    <div class="mb-4">
      <div class="flex justify-between">
        <label class="block mb-2 text-sm font-bold text-gray-700" for="password">Password</label>
        <a
          class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
          href="/password/reset"
          tabindex="-1"
        >Forgot Password?</a>
      </div>
      <input
        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
        :class="errors.password ? 'border-red-500' :null"
        id="password"
        type="password"
        name="password"
        placeholder="******************"
        v-model="password"
      />
    </div>
    <div class="mb-4">
      <input
        class="mr-2 leading-tight"
        type="checkbox"
        name="remember"
        id="remember"
        v-model="remember"
        true-value="yes"
        false-value
      />
      <label class="text-sm" for="remember">Remember Me</label>
    </div>
    <div class="mb-4 text-center">
      <button
        class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
        type="submit"
        :disabled="disabled"
        v-text="btnText"
      ></button>
    </div>
  </form>
</template>
<script>
export default {
  data() {
    return {
      username: "",
      password: "",
      remember: "",
      disabled: false,
      errors: {
        username: ""
      }
    };
  },
  computed: {
    btnText(){
      return this.disabled ? 'Please wait'  : 'Login';
    }
  },
  methods: {
    login() {
      this.disabled = true;
      axios
        .post("/login", {
          username: this.username,
          password: this.password,
          remember: this.remember
        })
        .then(response => {
          if (response.status == 204) {
            window.location.href = "/home";
          }
          this.disabled = false;
        })
        .catch(err => {
          this.errors = err.response.data.errors;
          this.disabled = false;
        });
    }
  }
};
</script>