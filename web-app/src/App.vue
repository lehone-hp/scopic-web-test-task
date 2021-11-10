<template>
  <div id="app">

    <header class="main-nav">
      <div class="container-fluid">
        <router-link to="/">
          <div class="logo"><img src="./assets/logo.png"></div>
        </router-link>

        <div class="dropdown">
          <a href="#" type="button" id="dropdownMenuButton" class=""
             data-toggle="dropdown">
            <div class="auth-block" v-if="isLoggedIn">
              <span class="mr-2">{{ authUser.username }}</span>
              <div class="auth-avatar">
                <img src="./assets/avatar.png">
              </div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item"
               v-on:click.prevent="logout"
               href="#">Logout</a>
          </div>
        </div>


      </div>
    </header>

    <main id="main">
      <div class="container-fluid">
        <router-view></router-view>
      </div>
    </main>

  </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: 'App',
  components: {},
  computed: {
    ...mapGetters(['isLoggedIn', 'authUser']),
  },
  methods: {
    logout: function () {
      this.$store.commit('logout')
      localStorage.removeItem('user')
      this.$router.push({'name': 'login'})
    }
  }
}
</script>

<style>
</style>
