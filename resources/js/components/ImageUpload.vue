<template>
  <input
    id="image"
    type="file"
    accept="image/*"
    required
    @change="onChange"
  />
</template>
<script>
export default {
  methods: {
    onChange(e) {
      if (!e.target.files[0]) return;

      let file = e.target.files[0];

      let reader = new FileReader();
      reader.readAsDataURL(file);
      
      reader.onload = e => {
        let src = e.target.result;
        this.$emit("loaded", { src, file });
      };
    }
  }
};
</script>