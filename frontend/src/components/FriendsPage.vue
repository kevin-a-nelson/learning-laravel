<template>
  <div class="container col-lg-6">
    <div class="post-actions create-post-btn-container">
      <a href="#" @click="() => setCurrentTab(MY_FRIENDS_TAB)" class="card-link">My Friends</a>
      &ensp;|&ensp;
      <a
        href="#"
        @click="() => setCurrentTab(ADD_FRIENDS_TAB)"
        class="card-link"
        >Add Friends</a
      >
      &ensp;|&ensp;
      <a href="#" @click="setCurrentTab(FRIEND_REQUESTS_TAB)" class="card-link"
        >Friend Requests</a
      >
    </div>
    <div v-if="currentTab === ADD_FRIENDS_TAB">
      <div v-for="user in users" v-bind:key="user.id" class="card">
        <div class="card-body">
          <h5 class="card-title">{{ user.name }}</h5>
          <h6 class="card-subtitle mb-2 text-muted">{{ user.email }}</h6>
          <div v-if="friendRequestSentToUser(user)">
            Friend request pending...
          </div>
          <div v-else>
            <a
              href="#"
              @click="() => createFriendRequest(user)"
              class="card-link"
              >Send Friend Request</a
            >
          </div>
        </div>
      </div>
    </div>
    <div v-if="currentTab === FRIEND_REQUESTS_TAB">
      <div v-if="incommingFriendRequests.length === 0">
        You have no incomming friend requests!
      </div>
      <div
        v-for="friendRequest in incommingFriendRequests"
        v-bind:key="friendRequest.id"
        class="card"
      >
        <div class="card-body">
          <h5 class="card-title">{{ friendRequest.senderUser.name }}</h5>
          <h6 class="card-subtitle mb-2 text-muted">
            {{ friendRequest.senderUser.email }}
          </h6>
          <!-- <div v-if="friendRequestSentToUser(user)">
            Friend request pending...
          </div> -->
          <div>
            <a href="#">Add</a>&ensp;|&ensp;<a
              href="#"
              @click="() => deleteFriendRequest(friendRequest)"
              >Delete</a
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FriendsPage",
  data() {
    return {
      MY_FRIENDS_TAB: 0,
      ADD_FRIENDS_TAB: 1,
      FRIEND_REQUESTS_TAB: 2,
      currentTab: 0,
      users: [],
      currentUser: {},
      friendRequests: [],
    };
  },

  mounted() {
    try {
      this.currentUser = JSON.parse(localStorage["user"]);
    } catch {
      this.currentUser = {};
    }
  },
  computed: {
    incommingFriendRequests() {
      return this.friendRequests.filter((friendRequest) => {
        return friendRequest.recipientId == this.currentUser?.id;
      });
    },
    outGoingFriendRequests() {
      return this.friendRequests.filter((friendRequest) => {
        return friendRequest.senderId == this.currentUser?.id;
      });
    },
  },
  methods: {
    async getFriendships() {
      // axios 
    },
    async setCurrentTab(tab) {
      this.currentTab = tab;

      if (tab === this.MY_FRIENDS_TAB) {
        await this.getFriendships();
      }

      if (tab === this.ADD_FRIENDS_TAB) {
        await this.GetUsers();
        await this.getFriendRequests();
      }

      if (tab === this.FRIEND_REQUESTS_TAB) {
        await this.getFriendRequests();
      }
    },

    friendRequestSentToUser(user) {
      for (let i = 0; i < this.friendRequests.length; i++) {
        if (this.friendRequests[i].recipientId === user.id) {
          return true;
        }
      }
      return false;
    },

    async deleteFriendRequest(friendRequest) {
      await axios.delete(
        `http://localhost:8000/api/friendRequests/${friendRequest.id}`
      );
      await this.getFriendRequests();
    },

    async createFriendRequest(user) {
      let friendRequests = {
        senderId: this.currentUser.id,
        recipientId: user.id,
      };
      await axios
        .post("http://localhost:8000/api/friendRequests", friendRequests)
        .then(() => {})
        .catch(() => {});

      await this.getFriendRequests();
    },

    async getFriendRequests() {
      let params = { userId: this.currentUser.id };
      await axios
        .get("http://localhost:8000/api/friendRequests", { params })
        .then((response) => {
          this.friendRequests = response.data;
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
