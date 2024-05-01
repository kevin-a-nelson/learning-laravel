<template>
  <div class="container col-lg-6">
    <div class="post-actions create-post-btn-container">
      <a href="#" class="card-link">My Friends</a>
      &ensp;|&ensp;
      <a
        href="#"
        @click="() => setCurrentTab(ADD_FRIENDS_TAB)"
        class="card-link"
        >Add Friends</a
      >
      &ensp;|&ensp;
      <a href="#" @click="$emit('get:posts', {})" class="card-link"
        >Friend Requests</a
      >
    </div>
    <div v-if="currentTab === ADD_FRIENDS_TAB"></div>
  </div>
</template>

<script>
import axios from "axios";

// const FRIEND_REQUESTS_TAB = 2;

export default {
  name: "FriendsPage",
  data() {
    return {
      MY_FRIENDS_TAB: 0,
      ADD_FRIENDS_TAB: 1,
      currentTab: 0,
    };
  },
  methods: {
    async setCurrentTab(tab) {
      this.currentTab = tab;

      if (tab === this.ADD_FRIENDS_TAB) {
        await this.GetUsers();
      }
    },
    async GetUsers() {
      await axios
        .get("http://localhost:8000/api/users")
        .then((response) => {
          console.log(response);
        })
        .catch(() => {});
    },
    async GetFriendRequests() {
      await axios
        .get("http://localhost:8000/api/friendRequests")
        .then((response) => {
          console.log(response);
        })
        .catch(() => {});
    },
  },
};
</script>

<style></style>
