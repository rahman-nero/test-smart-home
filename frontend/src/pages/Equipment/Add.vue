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

      <form @submit.prevent v-for="item in data" key="index">

        <div class="remove-button"><span @click="() => removeForm(item.id)">X</span></div>


        <label class="form-label">Модель</label>

        <select class="form-select mb-3" aria-label=".form-select-lg"
                @change="(e) => setSelect(item.id, e.target.value)">
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
              @input="(e) => setSerialNumber(item.id, e.target.value)"
              class="form-control"
              id="serial_number"
          >
        </div>

        <div class="mb-3">
          <label for="comment" class="form-label">Примечание</label>
          <textarea
              type="text"
              @input="(e) => setComment(item.id, e.target.value)"
              class="form-control"
              id="comment"
          ></textarea>
        </div>

        <hr>
      </form>


      <button type="submit" class="btn btn-secondary" @click="generationForm" style="margin-right: 10px">Добавить еще
      </button>
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
      data: [
        {id: 1, equipment_type_id: 1, serial_number: '', comment: ''},
      ],
      error: false,
      errorMessage: '',
      success: false,
    }
  },

  methods: {
    // Здесь можно также реализовать чтобы можно было форму удалять, а потом очищать объект из data, но я это опустил
    generationForm() {
      const lastElement = this.data[this.data.length - 1] ?? 1;
      this.data.push({
        id: lastElement.id + 1,
        equipment_type_id: 1,
        serial_number: '',
        comment: ''
      });
    },

    removeForm(id) {
      // Чтобы первую форму не удалили
      if (id === 1) {
        return;
      }
      this.data = this.data.filter((value, index) => value.id !== id);
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

        if (error.response.data.errors.length > 0) {
          this.errorMessage = `${error.response.data.message}, список: ${error.response.data.errors.join(',')}`;
        } else {
          this.errorMessage = `${error.response.data.message}`;
        }

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

    setComment(id, value) {
      this.data.forEach((element, index) => {
        if (element.id === id) {
          this.data[index].comment = value;
        }
      });
    },
    setSelect(id, value) {
      this.data.forEach((element, index) => {
        if (element.id === id) {
          this.data[index].equipment_type_id = +value;
        }
      });
    },
    setSerialNumber(id, value) {
      this.data.forEach((element, index) => {
        if (element.id === id) {
          this.data[index].serial_number = value;
        }
      });
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

.remove-button {
  margin: 20px 0;
  text-align: right;
  color: white;
}

.remove-button span {
  padding: 5px 7px;
  background: #117eeb;
  cursor: pointer;
  border-radius: 5px;
}

.remove-button span:hover {
  box-shadow: 0px 0px 5px rgba(0,0,0, .2);
}

</style>