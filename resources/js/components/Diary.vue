<template>
  <div class="text-gray-900 dark:text-gray-100 card w-64 bg-gray-100 dark:bg-gray-800 pb-2 md:p-5 mx-auto p-2 m-4 shadow-lg rounded-sm overflow-hidden">
    <div class="text-right text-xs text-gray-500 dark:text-gray-400 mb-1" v-text="date"></div>
    <details>
      <summary class="list-none cursor-pointer">
        <p class="notebook whitespace-pre-wrap line-clamp-4">{{ data.entry }}</p>
        <span class="text-blue-600 dark:text-blue-400 text-sm">show more</span>
      </summary>
      <p class="notebook whitespace-pre-wrap mt-2">{{ data.entry }}</p>
      <span class="text-blue-600 dark:text-blue-400 text-sm cursor-pointer" onclick="this.closest('details').removeAttribute('open')">show less</span>
    </details>
  </div>
</template>
<script>
export default {
  props: ["data"],
  computed: {
    date() {
      return new Intl.DateTimeFormat(navigator.language, {
        year: 'numeric', month: '2-digit', day: '2-digit',
        hour: '2-digit', minute: '2-digit'
      }).format(new Date(this.data.created_at));
    }
  }
};
</script>
