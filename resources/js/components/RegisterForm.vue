<template>
  <div class="w-full bg-gray-100 p-2 md:p-5 rounded-lg">
    <h1 class="pt-4 text-2xl font-semibold text-gray-800 text-center pb-2 sm:pb-4">Register now!</h1>
    <form
      method="POST"
      class="px-4 md:px-8 pt-6 pb-2 mb-4 bg-red-100 rounded"
      @submit.prevent="register"
    >
      <div class="flex flex-col sm:flex-row mb-4">
          <div class="sm:mr-2 w-full">
              <label class="block mb-2 text-sm font-bold text-gray-700" for="email">Email-Address</label>
              <input
                  id="email"
                  v-model="email"
                  :class="errors.email ? 'border-red-500' :null"
                  autocomplete="email"
                  autofocus
                  class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
                  name="email"
                  placeholder="john@example.com"
                  required
                  type="email"
                  @change="updateUsername"
              />
              <p
                  v-if="errors.email"
                  class="text-xs italic text-red-500"
                  role="alert"
                  v-text="errors.email[0]"
              ></p>
          </div>
          <div class="sm:ml-2 w-full">
              <label class="block mb-2 text-sm font-bold text-gray-700" for="username">Username</label>
              <username-input ref="usernameInput"></username-input>
          </div>
      </div>
      <div class="flex flex-col sm:flex-row mb-4">
        <div class="sm:mr-2 w-full">
          <label class="block mb-2 text-sm font-bold text-gray-700" for="password">Password</label>
          <input
            class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
            :class="errors.password ? 'border-red-500' :null"
            id="password"
            type="password"
            name="password"
            placeholder="******************"
            autocomplete="new-password"
            v-model="password"
          />
          <p
            v-if="errors.password"
            class="text-xs italic text-red-500"
            role="alert"
            v-text="errors.password[0]"
          ></p>
        </div>
        <div class="sm:ml-2 w-full">
          <label
            class="block mb-2 text-sm font-bold text-gray-700"
            for="password_confirmation"
          >Confirm Password</label>
          <input
            class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            placeholder="******************"
            v-model="password_confirmation"
          />
        </div>
      </div>
      <div class="mb-4 text-center">
        <button
          class="w-full bg-blue-200 active:bg-blue-300 text-blue-800 px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
          type="submit"
          :disabled="disabled"
          v-text="btnText"
        ></button>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      disabled: false,
      email: "",
      password: "",
      password_confirmation: "",
      errors: {
        password: ""
      }
    };
  },
  computed: {
      btnText() {
          return this.disabled ? "Creating your account,Please wait" : "Get Started Now...";
      },
      extractUsernameFromEmail() {
          let email = this.email;
          let nameParts = email.split("@");
          return (nameParts.length === 2) ? nameParts[0] : null;
      }
  },
  methods: {
      username() {
          return this.$refs.usernameInput;
      },
      updateUsername() {
          if (this.username().username) {
              return;
          }
          this.username().username = this.extractUsernameFromEmail;
      },
      register() {
          if (this.validate()) {
              this.disabled = true;
              axios
                  .post("/register", {
                      username: this.username().username,
                      email: this.email,
                      password: this.password,
                      password_confirmation: this.password_confirmation
                  })
          .then(response => {
            if (response.status == 201) {
              window.location.href = "/home";
            }
          })
          .catch(err => {
            this.errors = err.response.data.errors;
          })
          .finally(() => {
            this.disabled = false;
          });
      }
    },
    validate() {
      return this.validateUsername() && this.validatePassword();
    },
    validatePassword() {
      if (this.password === this.password_confirmation) {
        return true;
      }
      this.errors.password = ["The password confirmation does not match."];
      return false;
    },
    validateUsername() {
      let input = this.username();

      return input.isAvailable;
    }
  }
};
</script>
<style scoped>
.w-full {
  max-width: 42rem;
}
</style>
