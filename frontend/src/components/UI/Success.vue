<template>
  <div v-if="show" class="success">
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
.success {
  text-align: left;
  color: white;
  padding: 15px;
  background: green;
  margin-bottom: 10px;
}
</style>