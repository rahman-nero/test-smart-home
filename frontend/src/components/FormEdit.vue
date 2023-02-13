<template>
  <div class="form-container">
    <form @submit.prevent>

      <label class="form-label">Модель</label>
      <select class="form-select mb-3" aria-label=".form-select-lg">
        <option selected>Open this select menu</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>

      <div class="mb-3">
        <label for="serial_number" class="form-label">Серийный номер</label>
        <input type="text" class="form-control" id="serial_number">
      </div>

      <div class="mb-3">
        <label for="serial_number" class="form-label">Примечание</label>
        <textarea type="text" class="form-control" id="serial_number"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Создать</button>
    </form>
  </div>

</template>

<script>
export default {}
</script>

<style scoped>
.form-container {
  margin-top: 20px;
}
</style>