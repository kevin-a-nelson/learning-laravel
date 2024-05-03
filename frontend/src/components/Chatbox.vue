<template>
  <div>Chat box</div>
  <div>{{ friend.name }}</div>
</template>

<script>
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
    // await this.getFriendships();
  },
};
</script>

<style></style>
