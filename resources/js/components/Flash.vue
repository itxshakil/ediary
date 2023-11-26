<template>
  <div
    class="flash-alert border px-4 py-3 my-2 rounded w-64"
    :class="classes"
    role="alert"
    v-show="show"
    v-text="body"
  ></div>
</template>

<script>
export default {
  props: ["message"],
  data() {
    return {
      body: this.message,
      level: "success",
      show: false
    };
  },
  created() {
    if (this.message) {
      this.flash();
    }
    window.events.$on("flash", data => this.flash(data));
  },
  computed: {
    classes() {
      if (this.level == "success") {
        return "bg-green-100 text-green-700 border-green-400";
      }
      if (this.level == "danger") {
        return "bg-red-100 text-red-700 border-red-400";
      }
      if (this.level == "warning") {
        return "bg-yellow-100 text-yellow-700 border-yellow-400";
      }
    }
  },
  methods: {
    flash(data) {
      if (data) {
        this.body = data.message;
        this.level = data.level;
      }
      this.show = true;
      this.hide();
    },
    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3000);
    }
  }
};
</script>
<style scoped>
.flash-alert {
  position: fixed;
  top: 30px;
  right: 30px;
}
</style>