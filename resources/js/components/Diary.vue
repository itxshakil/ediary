<template>
  <div class="card w-64 bg-gray-100 pb-2 md:p-5 p-2 m-4 shadow-lg rounded overflow-hidden">
    <p v-text="diary.entry"></p>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data() {
    return {
      diary: this.data
    };
  }
};
</script>