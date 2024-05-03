<template>
  <div>
    <div class="chat-bubble-container d-flex flex-column" id="chat-bubbles">
      <div>
        <p class="col-6 msg right">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
          neque est, viverra ac rhoncus et, cursus eu leo. Quisque in tristique
          libero, sed rhoncus neque. Ut at enim id ligula consequat tempus in
          nec magna. Donec vitae libero eget mi malesuada rutrum. Integer ornare
          ante at ligula venenatis, quis blandit urna euismod.
        </p>
      </div>
      <div>
        <p class="col-6 msg left">
          Integer ornare ante at ligula venenatis, quis blandit urna euismod.
        </p>
      </div>
      <div>
        <p class="col-6 msg right">
          Integer ornare ante at ligula venenatis, quis blandit urna euismod.
        </p>
      </div>
      <div>
        <p class="col-6 msg left">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
          neque est, viverra ac rhoncus et, cursus eu leo. Quisque in tristique
          libero, sed rhoncus neque. Ut at enim id ligula consequat tempus in
          nec magna. Donec vitae libero eget mi malesuada rutrum. Integer ornare
          ante at ligula venenatis, quis blandit urna euismod. ge
        </p>
      </div>
      <div>
        <p class="col-6 msg right">
          Integer ornare ante at ligula venenatis, quis blandit urna euismod.
        </p>
      </div>
    </div>
    <input class="form-control chat-input" />
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
    var objDiv = document.getElementById("chat-bubbles");
    objDiv.scrollTop = objDiv.scrollHeight;
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
  padding: 9px;
  border-radius: 10px;
  display: block;
}

.msg.right {
  /* background-color: #2fa4e7; */
  background-color: #c184e7;
  float: right;
  color: white;
}

.msg.left {
  /* background-color: #593196; */
  /* background-color: #2fa4e7; */
  background-color: #eee;
}

.chat-input {
  margin-bottom: 20px;
  border-radius: 15px;

  border: 1px solid rgba(30, 30, 30, 0.4);
}

.chat-bubble-container {
  max-height: 70vh;
  overflow: scroll;
}
</style>
