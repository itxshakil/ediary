<template>
  <div class="h-12 flex justify-center items-center" title="Share" @click="share">
    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
      <path d="M0 0h24v24H0V0z" fill="none" />
      <path
        d="M18 16.1c-.8 0-1.4.3-2 .8l-7.1-4.2c.1-.2.1-.5.1-.7s0-.5-.1-.7L16 7.2c.5.5 1.2.8 2 .8 1.7 0 3-1.3 3-3s-1.3-3-3-3-3 1.3-3 3c0 .2 0 .5.1.7L8 9.8C7.5 9.3 6.8 9 6 9c-1.7 0-3 1.3-3 3s1.3 3 3 3c.8 0 1.5-.3 2-.8l7.1 4.2c-.1.2-.1.4-.1.6 0 1.6 1.3 2.9 2.9 2.9s2.9-1.3 2.9-2.9-1.2-2.9-2.8-2.9z"
        fill="#2c5282"
      />
    </svg>
  </div>
</template>
<script>
export default {
  methods: {
    share() {
      if (navigator.share) {
        navigator
          .share({
            title: "Ediary",
            text:
              "Check out this awesome online diary site. Where you can save your daily  journals. Its works offline also.",
            url: "https://ediary.shakiltech.com"
          })
          .then(() => console.log("Successful share"))
          .catch(error => console.log("Error sharing", error));
      } else {
        window.location.href =
          "https://www.facebook.com/sharer/sharer.php?u=https%3A//ediary.shakiltech.com";
      }
    }
  }
};
</script>