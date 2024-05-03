<template>
  <div class="container col-lg-6">
    <div class="post-actions create-post-btn-container">
      <a href="#" @click="() => setCurrentTab(MY_FRIENDS_TAB)" class="card-link"
        >My Friends
      </a>
      &ensp;|&ensp;
      <a
        href="#"
        @click="() => setCurrentTab(ADD_FRIENDS_TAB)"
        class="card-link"
        >Add Friends
      </a>
      &ensp;|&ensp;
      <a href="#" @click="setCurrentTab(FRIEND_REQUESTS_TAB)" class="card-link"
        >Friend Requests
      </a>
    </div>
    <div v-if="currentTab === MY_FRIENDS_TAB">
      <div v-if="formattedFriendships.length === 0">
        <p>You have no friends</p>
      </div>
      <div
        v-for="friendship in formattedFriendships"
        v-bind:key="friendship.id"
        class="card"
      >
        <div class="card-body">
          <h5 class="card-title">{{ friendship.user.name }}</h5>
          <h6 class="card-subtitle mb-2 text-muted">
            {{ friendship.user.email }}
          </h6>
          <div class="friend-action-buttons">
            <a href="#" @click="() => onChat(friendship.user)">Chat</a>
            <a href="#" @click="() => deleteFriendship(friendship)">Unfriend</a>
          </div>
        </div>
      </div>
    </div>
    <div v-if="currentTab === ADD_FRIENDS_TAB">
      <div
        v-for="user in usersExceptCurrentUser"
        v-bind:key="user.id"
        class="card"
      >
        <div class="card-body">
          <h5 class="card-title">{{ user.name }}</h5>
          <h6 class="card-subtitle mb-2 text-muted">{{ user.email }}</h6>
          <div v-if="friendRequestSentToUser(user)">
            Friend request pending...
          </div>
          <div v-else-if="userIsFriend(user)">Already a Friend</div>
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
          <div class="friendrequest-action-buttons">
            <a href="#" @click="() => createFriendShip(friendRequest)">Add</a>
            <a href="#" @click="() => deleteFriendRequest(friendRequest)"
              >Delete</a
            >
          </div>
        </div>
      </div>
    </div>
    <div v-if="currentTab === CHAT_BOX">
      <Chatbox :friend="chatBoxFriend" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Chatbox from "../components/Chatbox.vue";

export default {
  name: "FriendsPage",
  components: {
    Chatbox,
  },
  data() {
    return {
      MY_FRIENDS_TAB: 0,
      ADD_FRIENDS_TAB: 1,
      FRIEND_REQUESTS_TAB: 2,
      CHAT_BOX: 3,
      chatBoxFriend: {},
      currentTab: 0,
      users: [],
      currentUser: {},
      friendRequests: [],
      friendships: [],
    };
  },

  async mounted() {
    try {
      this.currentUser = JSON.parse(localStorage["user"]);
    } catch {
      this.currentUser = {};
    }
    await this.getFriendships();
  },
  computed: {
    usersExceptCurrentUser() {
      return this.users.filter((user) => {
        return user.id !== this.currentUser.id;
      });
    },
    formattedFriendships() {
      return this.friendships.map((f) => {
        return {
          id: f.id,
          user: f.userOneId === this.currentUser.id ? f.userTwo : f.userOne,
        };
      });
    },
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
    onChat(friend) {
      this.setCurrentTab(this.CHAT_BOX);
      this.chatBoxFriend = friend;
    },
    userIsFriend(user) {
      return this.formattedFriendships.some((friend) => {
        return friend.user.id === user.id;
      });
    },
    async deleteFriendship(friend) {
      await axios
        .delete(`http://localhost:8000/api/friendships/${friend.id}`)
        .then(() => {})
        .catch(() => {});
      await this.getFriendships();
    },
    async createFriendShip(friendRequest) {
      let newFriendship = {
        userOneId: friendRequest.recipientId,
        userTwoId: friendRequest.senderId,
      };
      await axios
        .post("http://localhost:8000/api/friendships", newFriendship)
        .then(() => {})
        .catch(() => {});

      await axios
        .delete(`http://localhost:8000/api/friendRequests/${friendRequest.id}`)
        .then(() => {})
        .catch(() => {});

      await this.getFriendRequests();
    },
    async getFriendships() {
      let params = { userId: this.currentUser.id };
      await axios
        .get(`http://localhost:8000/api/friendships`, { params })
        .then((response) => {
          this.friendships = response.data;
        })
        .catch(() => {});
    },
    async setCurrentTab(tab) {
      this.currentTab = tab;

      if (tab === this.MY_FRIENDS_TAB) {
        await this.getFriendships();
      }

      if (tab === this.ADD_FRIENDS_TAB) {
        await this.GetUsers();
        await this.getFriendRequests();
        await this.getFriendships();
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
      await this.getFriendships();
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

<style>
.friend-action-buttons {
  display: flex;
  justify-content: space-between;
}

.friendrequest-action-buttons {
  display: flex;
  justify-content: space-between;
}
</style>
