<template>
  <div>
    <div class="row">
      <div class="colm-form">
        <div class="form-container">
          <Error v-bind:show="error">{{ errorMessage }}</Error>
          <input type="text" v-model="form.email" placeholder="Email address">
          <input type="password" v-model="form.password" placeholder="Password">
          <button class="btn-login" style="cursor: pointer" @click="submit">Login</button>
          <button class="btn-new" @click="$router.push('/register')" style="cursor: pointer">Create account</button>
        </div>
      </div>
    </div>

  </div>

</template>

<script>
import Error from "@/components/UI/Error.vue";
import {mapActions} from "vuex";

export default {
  components: {Error},
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      error: false,
      errorMessage: '',
    };
  },
  methods: {
    ...mapActions(['login']),
    submit() {
      this.error = false;
      this.errorMessage = '';

      const email = this.form.email;
      const password = this.form.password;

      if (email === '' || password === '') {
        this.error = true;
        this.errorMessage = 'Вы должны заполнить поля';
        return;
      }

      this.login({email, password})
          .then(response => {
            this.$router.push('/');
          })
          .catch(error => {
            this.error = true;
            this.errorMessage = error.response.data.message;
          });

    }
  }
}
</script>

<style scoped>
.row {
  display: flex;
  justify-content: space-around;
  align-items: center;
  width: 100%;
  max-width: 1000px;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}


.colm-logo {
  flex: 0 0 50%;
  text-align: left;
}

.colm-form {
  flex: 0 0 40%;
  text-align: center;
}

.colm-form .form-container {
  background-color: #ffffff;
  border: none;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.1);
  margin-bottom: 30px;
  padding: 20px;
  max-width: 400px;
}

.colm-form .form-container input, .colm-form .form-container .btn-login {
  width: 100%;
  margin: 5px 0;
  height: 45px;
  vertical-align: middle;
  font-size: 16px;
}

.colm-form .form-container input {
  border: 1px solid #dddfe2;
  color: #1d2129;
  padding: 0 8px;
  outline: none;
}

.colm-form .form-container input:focus {
  border-color: #1877f2;
  box-shadow: 0 0 0 2px #e7f3ff;
}

.colm-form .form-container .btn-login {
  background-color: #1877f2;
  border: none;
  border-radius: 6px;
  font-size: 20px;
  padding: 0 16px;
  color: #ffffff;
  font-weight: 700;
}

.colm-form .form-container a {
  display: block;
  color: #1877f2;
  font-size: 14px;
  text-decoration: none;
  padding: 10px 0 20px;
  border-bottom: 1px solid #dadde1;
}

.colm-form .form-container a:hover {
  text-decoration: underline;
}

.colm-form .form-container .btn-new {
  background-color: #42b72a;
  border: none;
  border-radius: 6px;
  font-size: 17px;
  line-height: 48px;
  padding: 0 16px;
  color: #ffffff;
  font-weight: 700;
  margin-top: 20px;
}

.colm-form p {
  font-size: 14px;
}

.colm-form p a {
  text-decoration: none;
  color: #1c1e21;
  font-weight: 600;
}

.colm-form p a:hover {
  text-decoration: underline;
}

.footer-contents {
  position: relative;
  max-width: 1000px;
  margin: 0 auto;
}

footer ol {
  display: flex;
  flex-wrap: wrap;
  list-style-type: none;
  padding: 10px 0;
}

footer ol:first-child {
  border-bottom: 1px solid #dddfe2;
}

footer ol:first-child li:last-child button {
  background-color: #f5f6f7;
  border: 1px solid #ccd0d5;
  outline: none;
  color: #4b4f56;
  padding: 0 8px;
  font-weight: 700;
  font-size: 16px;
}

footer ol li {
  padding-right: 15px;
  font-size: 12px;
  color: #385898;
}

footer ol li a {
  text-decoration: none;
  color: #385898;
}

footer ol li a:hover {
  text-decoration: underline;
}

footer small {
  font-size: 11px;
}
</style>