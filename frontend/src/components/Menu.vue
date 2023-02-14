<template>
    <header class="header">
      <div class="header-links">
        <a @click="$router.push('/')">Список всех оборудований</a>
        <a @click="$router.push('/add')">Создание оборудования</a>
      </div>

      <SearchBar></SearchBar>
    </header>

    <div class="menu-margin"></div>
</template>

<script>
import SearchBar from "@/components/SearchBar.vue";

export default {
  components: {
    SearchBar
  }
}
</script>

<style scoped>
.header {
  width: 100%;
  position: fixed;
  display: flex;
  padding: 20px 10px;
  z-index: 2;
  background: #fafafa;
  border-bottom: 1px solid #e2ddda;
}

.header .header-links a {
  font-family: Helvetica, sans-serif;
  margin-left: 15px;
  color: black;
  font-size: 14px;
  cursor: pointer;
}


.header .header-links a:hover {
  color: grey;
}

.search {
  margin-left: 20px;
}

.menu-margin {
  height: 80px;
}
</style>