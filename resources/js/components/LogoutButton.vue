<template>
  <a href="/logout" @click.prevent="logout">Sign out</a>
</template>
<script>
export default {
  methods: {
    logout() {
      axios
        .post("/logout")
        .then(response => {
          if (response.status === 204) {
            this.$emit("loggedout");
            this.$root.user = undefined;
          }
        })
        .catch(error => {
          console.dir(error);
        });
    }
  }
};
</script>