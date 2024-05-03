<template>
  <div class="d-flex flex-column">
    <div class="">
      <p class="col-6 msg right">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
        neque est, viverra ac rhoncus et, cursus eu leo. Quisque in tristique
        libero, sed rhoncus neque. Ut at enim id ligula consequat tempus in nec
        magna. Donec vitae libero eget mi malesuada rutrum. Integer ornare ante
        at ligula venenatis, quis blandit urna euismod.
      </p>
    </div>
    <div class="">
      <p class="col-6 msg left">
        Integer ornare ante at ligula venenatis, quis blandit urna euismod.
      </p>
    </div>
    <div class="">
      <p class="col-6 msg right">
        Integer ornare ante at ligula venenatis, quis blandit urna euismod.
      </p>
    </div>
    <div class="">
      <p class="col-6 msg left">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
        neque est, viverra ac rhoncus et, cursus eu leo. Quisque in tristique
        libero, sed rhoncus neque. Ut at enim id ligula consequat tempus in nec
        magna. Donec vitae libero eget mi malesuada rutrum. Integer ornare ante
        at ligula venenatis, quis blandit urna euismod. ge
      </p>
    </div>
    <div class="">
      <p class="col-6 msg right">
        Integer ornare ante at ligula venenatis, quis blandit urna euismod.
      </p>
    </div>
  </div>
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
  },

  methods: {
    async getChatbox(userOneId, userTwoId) {
      let params = {
        userOneId,
        userTwoId,
      };
      await axios
        .get("http://localhost:8000/api/chatboxes", { params })
        .then((response) => {
          this.chatbox = response.data[0];
        })
        .catch(() => {});
    },

    async createChatbox(userOneId, userTwoId) {
      let params = {
        userOneId,
        userTwoId,
      };
      await axios
        .post("http://localhost:8000/api/chatboxes", params)
        .then(() => {})
        .catch(() => {});
    },
  },
};
</script>

<style>
.msg {
  padding: 7px;
  border-radius: 10px;
}

.msg.right {
  background-color: #ccc;
  float: right;
}

.msg.left {
  background-color: #555;
  color: white;
}
</style>
