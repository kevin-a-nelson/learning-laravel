<template>
  <div>
    <h3 class="chat-title">
      {{ friend.name }}
    </h3>
    <div class="chat-bubble-container d-flex flex-column" id="chat-bubbles">
      <div v-for="text in texts" v-bind:key="text?.id">
        <p v-if="text.senderId === currentUser.id" class="col-6 msg right">
          {{ text.message }}
        </p>
        <p v-else class="col-6 msg left">
          {{ text.message }}
        </p>
      </div>
    </div>
    <input
      v-model="newText"
      @keyup.enter="onChatEnter"
      class="form-control chat-input"
    />
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Chatbox",
  data() {
    return {
      newText: "",
      currentUser: {},
      chatbox: {},
      texts: [],
      interval: null,
    };
  },
  props: {
    friend: Object,
  },
  beforeUnmount() {
    clearInterval(this.interval);
  },

  async mounted() {
    try {
      this.currentUser = JSON.parse(localStorage["user"]);
    } catch {
      this.currentUser = {};
    }

    await this.getChatbox(this.currentUser?.id, this.friend?.id);

    if (!this.chatbox) {
      await this.createChatbox(this.currentUser?.id, this.friend?.id);
    }

    await this.getChatbox(this.currentUser?.id, this.friend?.id);

    await this.getTexts();

    var objDiv = document.getElementById("chat-bubbles");
    objDiv.scrollTop = objDiv.scrollHeight;

    this.interval = setInterval(() => {
      this.getTexts();
    }, 1000);
  },

  created() {},

  methods: {
    async onChatEnter() {
      let text = {
        message: this.newText,
        chatboxId: this.chatbox?.id,
        senderId: this.currentUser?.id,
      };

      await axios
        .post("http://localhost:8000/api/chattexts", text)
        .then(() => {})
        .catch(() => {});

      this.newText = "";

      await this.getTexts();
    },
    async getTexts() {
      let params = {
        chatboxId: this.chatbox?.id,
      };

      var objDiv = document.getElementById("chat-bubbles");
      let userIsScrolledToBottom =
        objDiv.scrollHeight - objDiv.scrollTop === 600;

      await axios
        .get("http://localhost:8000/api/chattexts", { params })
        .then((response) => {
          this.texts = response.data;
        })
        .catch(() => {});

      if (userIsScrolledToBottom) {
        objDiv.scrollTop = objDiv.scrollHeight;
      }
    },
    async getChatbox(userOneId, userTwoId) {
      let params = {
        userOneId,
        userTwoId,
      };
      await axios
        .get("http://localhost:8000/api/chatboxes", { params })
        .then((response) => {
          console.log(response.data);
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
  background-color: #c184e7;
  float: right;
  color: white;
}

.msg.left {
  background-color: #eee;
}

.chat-input {
  margin-bottom: 20px;
  border-radius: 15px;

  border: 1px solid rgba(30, 30, 30, 0.4);
}

.chat-bubble-container {
  height: 600px;
  overflow: scroll;
}

.chat-title {
}
</style>
