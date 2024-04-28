<template>
  <div class="card border-primary mb-3">
    <div class="flex card-header">
      <span> {{ post?.user?.name }}</span>
      <span> {{ post?.created_at }} </span>
    </div>
    <div class="card-body">
      <h4 class="card-title">{{ post?.title }}</h4>
      <p class="card-text">{{ post?.text }}</p>
      <div class="post-actions" v-if="currentUserId === post?.user?.id">
        <router-link class="nav-link active" :to="editLink">
          <a href="#" class="card-link">Edit</a>
        </router-link>
        <span>&ensp;|&ensp;</span>
        <router-link
          class="nav-link active"
          @click="deletePost"
          to="/post_deleted"
        >
          <a href="#" class="card-link">Delete</a>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Post",
  data() {
    return {
      editLink: "",
    };
  },
  methods: {
    async deletePost() {
      let url = `http://localhost:8000/api/posts/${this.$route.params.id}`;
      await axios
        .delete(url)
        .then(() => {})
        .catch(() => {});
    },
  },
  created() {
    this.editLink = `/edit_post/${this.$route.params.id}`;
  },
  props: {
    post: Object,
    currentUserId: Number,
  },
};
</script>

<style></style>
