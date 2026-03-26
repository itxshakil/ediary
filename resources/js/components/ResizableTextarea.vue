<template>
  <textarea class="auto-grow" v-bind="$attrs"><slot></slot></textarea>
</template>
<script>
// ResizableTextarea is now a thin wrapper; actual resizing is done via
// CSS `field-sizing: content` on the `.auto-grow` class in app.css.
export default {
  inheritAttrs: false
};
</script>