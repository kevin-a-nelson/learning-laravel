<template>
  <div>
    <Header />
    <div class="spacing"></div>
    <router-view></router-view>
    <div class="current-user-text" v-if="currentUser">
      <p>{{ currentUser.name }}</p>
    </div>
  </div>
</template>

<script>
import Header from "./components/Header.vue";

export default {
  name: "App",
  data() {
    return {
      currentUser: {},
    };
  },
  components: {
    Header,
  },

  mounted() {
    try {
      this.currentUser = JSON.parse(localStorage["user"]);
    } catch {
      this.currentUser = {};
    }
  },
};
</script>

<style>
.spacing {
  margin-top: 20px;
}

.current-user-text {
  /* height: 75px;
  width: 75px; */
  /* background-color: #547980; */
  position: fixed;
  /* padding-left: 10px; */
  bottom: 0px;
  right: 20px;
  /* margin-left: 1000px;
  margin-top: 550px;
  border-radius: 5px; */
}
</style>
