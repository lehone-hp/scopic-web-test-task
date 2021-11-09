<template>
  <div class="row justify-content-center">
    <div class="col-sm-9 col-lg-6 col-xl-5">
      <div class="card card-body border-0 rounded shadow-sm p-4 px-lg-5">
        <h3 class="text-center mb-4 mb-lg-5">Login</h3>
        <small class="d-block text-danger text-center" v-if="error_msg">{{ error_msg }}</small>
        <form @submit.prevent="login">
          <div class="form-group">
            <label>Username</label>
            <input type="text"
                   :class="{ 'is-invalid': $v.form.username.$error }"
                   v-model="$v.form.username.$model"
                   name="username"
                   class="form-control" placeholder="e.g. user1"/>
            <div class="invalid-feedback"
                 v-if="!$v.form.username.required">This field is required
            </div>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password"
                   :class="{ 'is-invalid': $v.form.password.$error }"
                   v-model="$v.form.password.$model"
                   name="password" class="form-control" placeholder="************"/>
            <div class="invalid-feedback"
                 v-if="!$v.form.password.required">This field is required
            </div>
          </div>
          <div class="pt-4 text-center">
            <button-spinner
                @click="login"
                :spinner="show_spinner">Login
            </button-spinner>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import {api} from "../../plugins/api";
import {required} from 'vuelidate/lib/validators'

export default {
  name: "LoginComponent",
  data: function () {
    return {
      form: {
        username: '',
        password: ''
      },
      show_spinner: false,
      error_msg: '',
    }
  },
  validations: function () {
    return {
      form: {
        username: {required},
        password: {required},
      }
    }
  },
  methods: {
    login: function () {
      this.error_msg = '';

      this.$v.$touch()
      if (this.$v.$invalid) {
        this.error_msg = 'Please fill the form correctly'
      } else {
        this.show_spinner = true;
        api
            .post(`/login`, this.form)
            .then(response => {
              const status = response.data.status;
              if (status === 'error') {
                this.error_msg = response.data.message
              } else if (status === 'success') {
                localStorage.setItem('user', JSON.stringify(response.data.user))
                this.$store.commit('setAuthUser', JSON.stringify(response.data.user));
                this.$router.push({'name': 'product_search'});
              }
            })
            .catch(() => {
              // todo: alert error occurred
            })
            .then(() => {
              this.show_spinner = false;
            });
      }
    }
  }
}
</script>

<style scoped>

</style>