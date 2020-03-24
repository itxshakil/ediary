<template>
  <div class="card w-64 bg-gray-100 pb-2 md:p-5 p-2 m-4 shadow-lg rounded overflow-hidden" :class="full?'w-full':null">
    <div class="text-right text-xs text-gray-700" v-text="date"></div>
    <p v-text="text" class="notebook"></p>
    <button class="text-blue-700" @click="full=!full" v-if="!full">show more</button>
    <button class="text-blue-700" @click="full=!full" v-if="full">show less</button>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data() {
    return {
      entry:this.data.entry,
      created_at:this.data.created_at,
      full:false
    };
  },
  computed: {
    date() {
      return this.formatDate(new Date(this.created_at));
    },
    text(){
      if(this.full){
        return this.entry
      }
      return this.entry.substring(0,250);
    }
  },
  methods: {
    formatDate(date) {
      //  let d = date.toDateString(); //"Fri Nov 11 2016"
      return (
        ("0" + date.getDate()).slice(-2) +
        "-" +
        ("0" + (date.getMonth() + 1)).slice(-2) +
        "-" +
        date.getFullYear() +
        " " +
        ("0" + date.getHours()).slice(-2) +
        ":" +
        ("0" + date.getMinutes()).slice(-2)
      );
    }
  }
};
</script>