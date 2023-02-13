<template>
  <div v-if="show" class="error">
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      default: false,
    }
  }
}
</script>

<style  scoped>
.error {
  text-align: left;
  color: white;
  padding: 15px;
  background: red;
  margin-bottom: 10px;
}
</style>