<template>
  <div class="posts-container">
    <div class="container col-lg-6">
      <DashboardActions :currentUser="currentUser" @get:posts="getPosts" />

      <div v-for="post in posts" :key="post.id">
        <Post :post="post" :currentUser="currentUser" :showView="true" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import router from "../routes/routes.js";
import Post from "../components/Post.vue";
import DashboardActions from "../components/DashboardActions.vue";

export default {
  name: "Posts",
  components: {
    Post,
    DashboardActions,
  },
  data() {
    return {
      posts: [],
      currentUser: {},
    };
  },
  mounted() {
    try {
      this.currentUser = JSON.parse(localStorage["user"]);
    } catch {
      this.currentUser = {};
    }
    this.getPosts();
  },
  methods: {
    async getPosts(params) {
      let url = "http://localhost:8000/api/posts";
      await axios
        .get(url, { params })
        .then((response) => {
          this.posts = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    viewPost(postId) {
      router.push(`/posts/${postId}`);
    },
  },
};
</script>

<style>
.post-actions {
  display: flex;
}

.posts-container {
  margin-top: 20px;
}

.create-post-btn-container {
  /* margin-top: 10px; */
  margin-bottom: 20px;
}

.flex {
  display: flex;
  justify-content: space-between;
}
</style>
