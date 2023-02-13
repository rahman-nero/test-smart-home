<template>
  <div>
    <Menu/>
    <div class="container">

      <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
          <h2 class="heading-section">Список всех оборудований</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">

          <div class="table-wrap" v-if="equipments.length > 0 && error === false">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Id</th>
                <th>Название</th>
                <th>Маска</th>
                <th>Примечание</th>
                <th>Добавлено</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="equipment in equipments">
                <th scope="row">{{ equipment.id }}</th>
                <td>{{ equipment.type.title }}</td>
                <td>{{ equipment.serial_number }}</td>
                <td>{{ equipment.comment }}</td>
                <td>{{ equipment.created_at }}</td>
                <td>
                  <a @click="$router.push(`/show/${equipment.id}`)">Посмотреть</a>
                  <a @click="$router.push(`/edit/${equipment.id}`)">Изменить</a>
                  <a @click="() => remove(equipment.id)">Удалить</a>
                </td>

              </tr>
              </tbody>
            </table>

            <!-- Pagination -->
            <div class="pages" v-if="totalPages >= page">
              <button :class="{
                page: true,
                current: pageNumber === page
              }" v-for="pageNumber in totalPages" @click="changePage(pageNumber)">
                {{ pageNumber }}
              </button>
            </div>

          </div>

          <div v-else-if="equipments.length === 0">
            Пожалуйста добавьте оборудование
          </div>

          <div v-else-if="error">
            Произошла ошибка при загрузке данных
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script>
import Menu from "@/components/Menu.vue";
import {mapActions, mapState} from "vuex";

export default {
  components: {Menu},
  methods: {
    ...mapActions(['loadData', 'changePage', 'deleteEquipment']),
    remove(id) {
      this.deleteEquipment(id)
          .then(() => {
            this.loadData();
          })
          .catch(() => {
            this.error = true;
          });
    }
  },
  mounted() {
    this.loadData();
  },
  computed: {
    ...mapState({
      limit: state => state.equipment.limit,
      totalPages: state => state.equipment.totalPages,
      equipments: state => state.equipment.equipments,
      page: state => state.equipment.page,
      error: state => state.equipment.error,
    }),
  }
}
</script>

<style>

.pages {
  margin-top: 10px;
}

.pages .page {
  padding: 5px 10px;
  border: 1px solid grey;
}

.current {
  color: white;
  background: grey;
}

.pages .page:hover {
  background: grey;
  color: white;
}


</style>