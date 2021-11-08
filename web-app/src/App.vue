<template>
  <div id="app">

    <header class="main-nav">
      <div class="container-fluid">
        <router-link to="/">
          <div class="logo"><img src="./assets/logo.png"></div>
        </router-link>

        <div class="auth-block">
          <span class="mr-2">User Name</span>
          <div class="auth-avatar">
            <img src="./assets/avatar.png">
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

export default {
  name: 'App',
  components: {}
}
</script>

<style>
</style>
