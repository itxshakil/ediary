<template>
  <div>
    <input
      class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
      :class="error? 'border-red-500' :null"
      id="username"
      type="text"
      placeholder="john.doe"
      name="username"
      required
      autofocus
      v-model="username"
      autocomplete="off"
      @change="check"
    />
    <p
      class="text-xs italic mt-2"
      :class="error? 'text-red-800' :'text-green-800'"
      role="alert"
      v-text="message"
    ></p>
  </div>
</template>
<script>
export default {
  props: {
    iserror: {
      type: Boolean,
      default: false,
    },
    value: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      username: this.value,
      isAvailable: false,
      error: this.iserror,
    };
  },
  mounted() {
    this.check();
  },
  computed: {
    message() {
      let message = "The username must be at least 5 characters.";
      if (this.username.length > 4) {
        if (this.isAvailable) {
          message = this.username + " is available.";
        }
          message = this.username + " is already taken.";

      }

      return message;
    },
  },
  methods: {
    check() {
      if (this.username.length > 4) {
          axios
              .post("/api/check-username", {username: this.username})
          .then((response) => {
              if(response.status  ===  200){
                  this.error = false;
                  this.isAvailable = true;
              }else{
                  this.error = true;
                  this.isAvailable = false;
              }
          })
          .catch((error) => {
            this.error = true;
            this.isAvailable = false;
          });
      }
    },
  },
};
</script>
