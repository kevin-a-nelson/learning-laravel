<template>
  <div v-if="currentUser" class="post-actions create-post-btn-container">
    <router-link class="nav-link active" to="/create_post">
      <a href="#" class="card-link">Create Post</a>
    </router-link>
    &ensp;|&ensp;
    <a
      href="#"
      @click="$emit('get:posts', { userId: currentUser.id })"
      class="card-link"
      >My Posts</a
    >
    &ensp;|&ensp;
    <a href="#" @click="$emit('get:posts', {})" class="card-link">All Posts</a>
  </div>
</template>

<script>
export default {
  name: "DashboardActions",

  props: {
    isLoggedIn: Boolean,
    currentUser: Object,
  },
};
</script>

<style></style>
