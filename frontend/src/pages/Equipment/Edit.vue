<template>
  <Menu></Menu>

  <!-- Form -->
  <div class="container" v-if="!isLoading">
    <h2>Форма редактирования оборудования</h2>

    <div class="form-container">
      <!-- Displaying Validation Errors -->
      <Error v-bind:show="validationErrors !== ''">{{ validationErrors }}</Error>

      <!-- Message after successfully sent -->
      <Success v-bind:show="success">{{ successMessage }}</Success>

      <form @submit.prevent>
        <label class="form-label">Модель</label>

        <select class="form-select mb-3" aria-label=".form-select-lg" v-model="data.equipment_type_id">
          <option v-for="option in options" :key="option.id" :value="option.id">{{ option.title }}</option>
        </select>

        <div class="mb-3">
          <label for="serial_number" class="form-label">Серийный номер</label>
          <input type="text" class="form-control" id="serial_number" v-model="data.serial_number">
        </div>

        <div class="mb-3">
          <label for="serial_number" class="form-label">Примечание</label>
          <textarea type="text" class="form-control" id="serial_number" v-model="data.comment"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" @click="send">Обновить</button>
      </form>
    </div>
  </div>

  <!--  Loading block  -->
  <div class="container" v-else-if="isLoading">
    Загрузка....
  </div>

</template>

<script>
import Menu from "@/components/Menu.vue";
import Error from "@/components/UI/Error.vue";
import Success from "@/components/UI/Success.vue";
import {edit, show} from "@/services/EquipmentService";
import {getAllTypes} from "@/services/EquipmentTypeService";

export default {
  components: {Success, Error, Menu},
  data() {
    return {
      options: [],
      data: {
        equipment_type_id: 1,
        serial_number: '',
        comment: '',
      },
      isLoading: true,
      success: false,
      successMessage: '',
      validationErrors: '',
    }
  },
  methods: {
    async loadContent(id) {
      try {
        const response = await show(id);
        this.data.equipment_type_id = response.data.message.type_id;
        this.data.serial_number = response.data.message.serial_number;
        this.data.comment = response.data.message.comment;
      } catch (error) {
        this.$router.push('/');
      } finally {
        this.isLoading = false;
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

    send() {
      this.validationErrors = '';
      this.success = false;
      this.successMessage = '';

      const id = this.$route.params.id;
      const data = {
        type_id: this.data.equipment_type_id,
        serial_number: this.data.serial_number,
        comment: this.data.comment,
      };


      edit(id, data)
          .then((response) => {
            this.success = true;
            this.successMessage = 'Оборудование успешно обновлено';
          })
          .catch((error) => {
            this.validationErrors = error.response.data.message;
          })
    }
  },
  mounted() {
    this.fetchOptions();
    this.loadContent(this.$route.params.id);
  }
}
</script>

<style scoped>
.form-container {
  margin-top: 20px;
}
</style>