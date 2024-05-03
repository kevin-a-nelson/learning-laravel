<template>
  <div>Chat box</div>
  <div>{{ friend.name }}</div>
</template>

<script>
import axios from "axios";

export default {
  name: "Chatbox",
  data() {
    return {
      currentUser: {},
      chatbox: {},
    };
  },
  props: {
    friend: Object,
  },

  async mounted() {
    try {
      this.currentUser = JSON.parse(localStorage["user"]);
    } catch {
      this.currentUser = {};
    }

    this.chatbox = await this.getChatbox(this.currentUser.id, this.friend.id);

    if (!this.chatbox) {
      this.chatbox = await this.createChatbox(
        this.currentUser.id,
        this.friend.id
      );
    }
  },

  methods: {
    async getChatbox(userOneId, userTwoId) {
      let params = {
        userOneId,
        userTwoId,
      };
      await axios.get("http://localhost:8000/api/chatboxes", { params });
    },

    async createChatbox(userOneId, userTwoId) {
      let params = {
        userOneId,
        userTwoId,
      };
      await axios
        .post("http://localhost:8000/api/chatboxes", { params })
        .then(() => {})
        .catch(() => {});
    },
  },
};
</script>

<style></style>
