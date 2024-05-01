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
    <div v-if="currentTab === ADD_FRIENDS_TAB">
      <div v-for="user in users" v-bind:key="user.id" class="card">
        <div class="card-body">
          <h5 class="card-title">{{ user.name }}</h5>
          <h6 class="card-subtitle mb-2 text-muted">{{ user.email }}</h6>
          <a href="#" @click="() => createFriendRequest(user)" class="card-link"
            >Send Friend Request</a
          >
        </div>
      </div>
    </div>
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
      users: [],
      currentUser: {},
    };
  },

  mounted() {
    try {
      this.currentUser = JSON.parse(localStorage["user"]);
    } catch {
      this.currentUser = {};
    }
  },
  methods: {
    async setCurrentTab(tab) {
      this.currentTab = tab;

      if (tab === this.ADD_FRIENDS_TAB) {
        await this.GetUsers();
      }
    },
    async createFriendRequest(user) {
      let friendRequests = {
        senderId: this.currentUser.id,
        recipientId: user.id,
        // message: "",
      };
      await axios
        .post("http://localhost:8000/api/friendRequests", friendRequests)
        .then(() => {
          // this.users = response.data;
        })
        .catch(() => {});
    },
    async GetUsers() {
      await axios
        .get("http://localhost:8000/api/users")
        .then((response) => {
          this.users = response.data;
        })
        .catch(() => {});
    },
  },
};
</script>

<style></style>
