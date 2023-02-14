<template>

  <Menu></Menu>
  <!-- Form -->
  <div class="container">
    <h2>Форма добавления оборудования</h2>
    <div class="form-container">

      <!-- Displaying Errors -->
      <Error v-bind:show="error">{{ errorMessage }}</Error>

      <!-- Message after successfully sent -->
      <Success v-bind:show="success">Вы успешно добавили оборудование. Переадресацие через 3 секунды</Success>

      <form @submit.prevent v-for="index in form_count" key="index">
        <label class="form-label">Модель</label>

        <select class="form-select mb-3" aria-label=".form-select-lg"
                @change="(e) => setSelect(index - 1, e.target.value)">
          <option
              v-for="option in options"
              :key="option.id"
              :value="option.id"
          >
            {{ option.title }}
          </option>
        </select>

        <div class="mb-3">
          <label for="serial_number" class="form-label">Серийный номер</label>
          <input
              type="text"
              @input="(e) => setSerialNumber(index-1, e.target.value)"
              class="form-control"
              id="serial_number"
          >
        </div>

        <div class="mb-3">
          <label for="comment" class="form-label">Примечание</label>
          <textarea
              type="text"
              @input="(e) => setComment(index-1, e.target.value)"
              class="form-control"
              id="comment"
          ></textarea>
        </div>

        <hr>
      </form>


      <button type="submit" class="btn btn-secondary" @click="generationForm" style="margin-right: 10px">Добавить еще</button>
      <button type="submit" class="btn btn-primary" @click="send">Отправить</button>
    </div>
  </div>

</template>

<script>
import Error from "@/components/UI/Error.vue";
import Success from "@/components/UI/Success.vue";
import Menu from "@/components/Menu.vue";
import {getAllTypes} from "@/services/EquipmentTypeService";
import {multipleAdd} from "@/services/EquipmentService";

export default {
  components: {Success, Error, Menu},
  data() {
    return {
      options: [],
      form_count: 1,
      data: [
        {equipment_type_id: 1, serial_number: '', comment: ''},
      ],
      error: false,
      errorMessage: '',
      success: false,
    }
  },

  methods: {
    // Здесь можно также реализовать чтобы можно было форму удалять, а потом очищать объект из data, но я это опустил
    generationForm() {
      this.form_count += 1;
      this.data = [...this.data, {equipment_type_id: 1, serial_number: '', comment: ''}];
    },

    async send() {
      this.error = false;
      this.success = false;
      this.errorMessage = '';

      try {
        await multipleAdd(this.data);
        this.success = true;
        setTimeout(() => this.$router.push('/'), 3000);

      } catch (error) {
        this.error = true;
        this.errorMessage = error.response.data.message;
      }
    },
    async fetchOptions() {
      try {
        const response = await getAllTypes();
        this.options = response.data.message.data;
      } catch (error) {
        alert(error)
      }
    },

    setComment(index, value) {
      this.data[index].comment = value;
    },
    setSelect(index, value) {
      this.data[index].equipment_type_id = +value;
    },
    setSerialNumber(index, value) {
      this.data[index].serial_number = value;
    },

  },

  mounted() {
    this.fetchOptions();
  }

}
</script>

<style scoped>
.form-container {
  margin-bottom: 50px;
}
</style>