<template>
  <div>
    <Header title="Dashboard" />
    <div class="spacing"></div>
    <router-view></router-view>
  </div>
</template>

<script>
import Header from './components/Header.vue'

export default {
  name: 'App',
  components: {
    Header
  },
}
</script>

<style>
.spacing {
  margin-top: 20px;
}
</style>
