<template>
  <Menu></Menu>

  <!-- Form -->
  <div class="container" v-if="!isLoading && !error">
    <h2>Форма редактирования оборудования - </h2>

    <div class="form-container">
      <Error v-bind:show="validationErrors !== ''">{{ validationErrors }}</Error>
      <Success v-bind:show="success">{{ successMessage }} </Success>

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
  <div class="container" v-else-if="isLoading && !error">
    Загрузка....
  </div>

  <!--  Error block  -->
  <Error v-bind:show="error">{{ errorMessage }}</Error>


</template>

<script>
import Menu from "@/components/Menu.vue";
import $host from "@/api/config";
import {getHeaderSnippet} from "@/utils/common";
import Error from "@/components/UI/Error.vue";
import Success from "@/components/UI/Success.vue";

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
      error: false,
      errorMessage: '',
      success: false,
      successMessage: '',
      validationErrors: '',
    }
  },
  methods: {

    async loadContent(id) {
      try {
        const response = await $host.get(`/equipment/${id}`, {...getHeaderSnippet()});
        this.data.equipment_type_id = response.data.message.type_id;
        this.data.serial_number = response.data.message.serial_number;
        this.data.comment = response.data.message.comment;

      } catch (error) {
        this.error = true;

        if (error.response.data.code === 404) {
          this.errorMessage = 'Такого оборудования нет. Пожалуйста проверьте id';
        } else {
          this.errorMessage = 'Ошибка';
        }

      } finally {
        this.isLoading = false;
      }
    },

    // TODO: Дублирование в add.vue
    async fetchOptions() {
      try {
        const response = await $host.get('/equipment-type', {
          ...getHeaderSnippet(),
          params: {
            limit: 0
          }
        });
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
      $host.put(`/equipment/${id}`, data, {
        ...getHeaderSnippet(),
      })
      .then((response) => {
        this.success = true;
        this.successMessage = 'Оборудование успешно обновлено';
      })
      .catch((error) => {
        if(error.response.status === 422) {
          this.validationErrors = error.response.data.message;
        }
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