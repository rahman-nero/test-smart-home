import { createRouter, createWebHistory } from 'vue-router'
import Login from "@/pages/Auth/Login.vue";
import SignUp from "@/pages/Auth/SignUp.vue";
import store from "@/store";
import Main from "@/pages/Main.vue";
import {getToken} from "@/utils/common";
import Edit from "@/pages/Equipment/Edit.vue";
import Show from "@/pages/Equipment/Show.vue";
import Add from "@/pages/Equipment/Add.vue";

const routes = [
  { path: '/', component: Main },
  { path: '/add', component: Add },
  { path: '/edit/:id', component: Edit },
  { path: '/show/:id', component: Show },
  { path: '/login',  component: Login },
  { path: '/register', component: SignUp },
]

const router = createRouter({
  routes: routes,
  history: createWebHistory(process.env.BASE_URL),
});

const token = getToken();

router.beforeEach(async(to, from) => {
  if (token !== null) {
    await store.dispatch('authorization');
  }

  const isAuthenticated = store.state.user.isAuth;

  if (
      !isAuthenticated && to.path !== '/login' && to.path !== '/register'
  ) {
    // redirect the user to the login page
    return {path: '/login'}
  }

  // if user is authenticated, redirect to main page
  if (isAuthenticated && to.path === '/login') {
      return {path: "/"}
  }

  if (isAuthenticated && to.path === '/register') {
      return {path: "/"}
  }
})

export default router
