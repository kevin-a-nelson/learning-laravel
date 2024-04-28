<template>
  <div class="card border-primary mb-3">
    <div class="flex card-header">
      <span> {{ post?.user?.name }}</span>
      <span> {{ post?.created_at }} </span>
    </div>
    <div class="card-body">
      <h4 class="card-title">{{ post?.title }}</h4>
      <p class="card-text">{{ post?.text }}</p>
      <a href="#" v-if="showView" @click="goToView" class="card-link">View</a>
      <span v-if="showView && showEdit && post?.user?.id === currentUser?.id"
        >&ensp;|&ensp;</span
      >
      <a
        href="#"
        v-if="showEdit && post?.user?.id === currentUser?.id"
        @click="goToEdit"
        class="card-link"
        >Edit</a
      >
      <span
        v-if="
          showEdit &&
          post?.user?.id === currentUser?.id &&
          showDelete &&
          post?.user?.id === currentUser?.id
        "
        >&ensp;|&ensp;</span
      >
      <a
        href="#"
        v-if="showDelete && post?.user?.id === currentUser?.id"
        @click="deletePost"
        class="card-link"
        >Delete</a
      >
    </div>
  </div>
</template>

<script>
import axios from "axios";
import router from "../routes/routes.js";

export default {
  name: "Post",
  methods: {
    async deletePost() {
      let url = `http://localhost:8000/api/posts/${this.$route.params.id}`;
      await axios
        .delete(url)
        .then(() => {})
        .catch(() => {});
      router.push(`/post_deleted`);
    },
    goToEdit() {
      router.push(`/edit_post/${this.post.id}`);
    },
    goToView() {
      router.push(`/posts/${this.post.id}`);
    },
  },
  props: {
    post: Object,
    currentUser: Object,
    showView: Boolean,
    showEdit: Boolean,
    showDelete: Boolean,
  },
};
</script>

<style></style>
