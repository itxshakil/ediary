<template>
  <div
    v-if="navigatorSupportShare"
    class="h-12 flex justify-center items-center"
    title="Share"
    @click="share"
  >
    <img class="w-4" src="/icons/svg/share.svg" alt="share-icon" />
  </div>
</template>
<script>
export default {
  computed: {
    navigatorSupportShare() {
      return navigator.share;
    }
  },
  methods: {
    share() {
      if (this.navigatorSupportShare) {
        navigator
          .share({
            title: "AppEdiary",
            text: "Check out AppEdiary",
            url: "https://appediary.herokuapp.com"
          })
          .then(() => console.log("Successful share"))
          .catch(error => console.log("Error sharing", error));
      }
    }
  }
};
</script>