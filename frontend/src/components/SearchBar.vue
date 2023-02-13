<template>
      <div class="search">
        <input type="text" v-model="query">

        <div class="result" v-if="data.length > 0">
          <div class="item" v-for="item in data" key="item.id" @click="() => redirect(item)">
            {{ item.id }} - {{ item.serial_number }}
          </div>
        </div>
      </div>

</template>

<script>
import {getHeaderSnippet} from "@/utils/common";
import $host from "@/api/config";

export default {
  data() {
    return {
      query: '',
      data: []
    }
  },
  methods: {
    async loadResult() {
      try {
        const response = await $host.get('/equipment', {
          params: {
            query: this.query
          },
          ...getHeaderSnippet()
        });

        this.data = [...response.data.message];
      } catch(error) {
        console.log('SearchBar', error);
      }

    },

    redirect(item) {
      this.query = '';
      this.data = [];

      this.$router.push(`/show/${item.id}`)
    }
  },
  watch: {
    query(query) {
      if (query !== '') {
        this.loadResult();
      }

      if (query === '') {
        this.data = [];
      }
    }
  }
}
</script>

<style scoped>

.result {
  position: absolute;
  width: 240px;
  background: #fafafa;
}

.item {
  padding: 10px;
  cursor: pointer;
  border-bottom: 1px solid grey;
}

</style>