<template>
  <Menu></Menu>
  <!-- Form -->
  <div class="container" v-if="!isLoading && !error">

    <h2>Оборудование - {{ data.serial_number }}</h2>

    <div class="form-container">
      <form @submit.prevent>

        <div class="mb-3">
          <label class="form-label">Модель</label>
          <input type="text" class="form-control" id="serial_number" disabled v-model="data.type">
        </div>

        <div class="mb-3">
          <label for="serial_number" class="form-label">Серийный номер</label>
          <input type="text" class="form-control" id="serial_number" v-model="data.serial_number" disabled>
        </div>

        <div class="mb-3">
          <label for="serial_number" class="form-label">Примечание</label>
          <textarea type="text" class="form-control" id="serial_number" v-model="data.comment" disabled></textarea>
        </div>


        <button type="button" class="btn btn-primary" style="margin-right: 7px"
                @click="$router.push(`/edit/${$route.params.id}`)">Редактировать
        </button>
        <button type="button" class="btn btn-danger" @click="remove">Удалить</button>
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
import {mapActions} from "vuex";

export default {
  components: {Error, Menu},
  data() {
    return {
      data: {
        type: '',
        serial_number: '',
        comment: '',
      },
      isLoading: true,
      error: false,
      errorMessage: '',
    }
  },
  methods: {
    ...mapActions(['deleteEquipment']),
    async loadContent(id) {
      try {
        const response = await $host.get(`/equipment/${id}`, {...getHeaderSnippet()});
        this.data.type = response.data.message.type;
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
    async remove() {
      this.deleteEquipment(this.data.id)
          .then((response) => {
            this.$router.push('/');
          })
          .catch((error) => {
            this.error = true;
            this.errorMessage = 'Не удалось удалить запись';
          });
    }
  },
  mounted() {
    this.loadContent(this.$route.params.id);
  },
  // Если не поставить это, то перенаправление с поиска не работает нормально.
  updated() {
    this.loadContent(this.$route.params.id);
  }
}
</script>

<style scoped>
.form-container {
  margin-top: 20px;
}
</style>