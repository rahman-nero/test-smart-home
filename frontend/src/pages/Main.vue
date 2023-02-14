<template>
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
            <tr v-for="equipment in equipments" key="equipment.id">
              <th scope="row">{{ equipment.id }}</th>
              <td>{{ equipment.type.title }}</td>
              <td>{{ equipment.serial_number }}</td>
              <td>{{
                  equipment.comment !== null
                      ? equipment.comment.substring(0, 10) + '...'
                      : ''
                }}
              </td>
              <td>{{ equipment.created_at }}</td>
              <td class="panel">
                <a @click="$router.push(`/show/${equipment.id}`)"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <a @click="$router.push(`/edit/${equipment.id}`)"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <a @click="() => remove(equipment.id)"><i class="fa fa-times" aria-hidden="true"></i></a>
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
</template>

<script>
import Menu from "@/components/Menu.vue";
import {mapActions, mapState} from "vuex";
import {deleteItem} from "@/services/EquipmentService";

export default {
  components: {Menu},
  methods: {
    ...mapActions(['loadData', 'changePage']),
    remove(id) {
      deleteItem(id)
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
      limit: state => state.mainPage.limit,
      totalPages: state => state.mainPage.totalPages,
      equipments: state => state.mainPage.equipments,
      page: state => state.mainPage.page,
      error: state => state.mainPage.error,
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

.table-wrap .panel a {
  font-size: 20px;
  margin: 0px 10px;
  cursor: pointer;
}


</style>