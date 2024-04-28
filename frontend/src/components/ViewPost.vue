<template>
  <div class="posts-container">
    <div class="container col-lg-6">
      <div class="card border-primary mb-3">
        <!-- <div class="card-header">{{ postAuthor }}</div> -->
        <div class="flex card-header">
          <span> {{ post?.user?.name }}</span>
          <span> {{ post.created_at }} </span>
        </div>
        <div class="card-body">
          <h4 class="card-title">{{ post.title }}</h4>
          <p class="card-text">{{ post.text }}</p>
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

      <NewCommentForm @create:comment="createComment" />

      <div v-for="comment in comments" :key="comment.id">
        <Comment
          :comment="comment"
          :commentBeingEdited="commentBeingEdited"
          :currentUserId="currentUserId"
          @update:commentBeingEdited="updateCommentBeingEdited"
          @update:comment="updateComment"
          @delete:comment="deleteComment"
        />
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

import Comment from "../components/Comment.vue";
import NewCommentForm from "../components/NewCommentForm.vue";

export default {
  name: "ViewPost",

  components: {
    Comment,
    NewCommentForm,
  },

  data() {
    return {
      postAuthor: "",
      post: {},
      postTitle: "",
      postText: "",
      commentText: "",
      commentBeingEdited: -1,
      editLink: "",
      currentUserId: -1,
      postAuthorId: -1,
      postId: -1,
      newCommentText: "",
      comments: [],
    };
  },

  methods: {
    async updateComment(comment) {
      console.log(comment);
      let url = `http://localhost:8000/api/comments/${comment.id}`;

      await axios
        .post(url, comment)
        .then(() => {
          this.newCommentText = "";
          this.commentBeingEdited = -1;
        })
        .catch(() => {});

      await this.getComments();
    },

    cancelCommentEdit() {
      this.newCommentText = "";
      this.commentBeingEdited = -1;
    },
    updateCommentBeingEdited(comment) {
      this.newCommentText = comment.text;
      this.commentBeingEdited = comment.id;
      this.getComments();
    },
    async deleteComment(comment) {
      this.commentBeingEdited = {};
      let url = `http://localhost:8000/api/comments/${comment.id}`;

      await axios
        .delete(url)
        .then(() => {})
        .catch(() => {});

      await this.getComments();
    },

    async getComments() {
      let url = `http://localhost:8000/api/comments?postId=${this.postId}`;

      await axios
        .get(url)
        .then((response) => {
          this.comments = response.data;
        })
        .catch(() => {});
    },

    async createComment(commentText) {
      let url = `http://localhost:8000/api/comments`;
      let userId = JSON.parse(localStorage["user"])?.id;
      let comment = {
        text: commentText,
        userId: userId,
        postId: this.$route.params.id,
      };

      await axios
        .post(url, comment)
        .then(() => {
          this.commentText = "";
        })
        .catch(() => {});

      await this.getComments();
    },

    async deletePost() {
      let url = `http://localhost:8000/api/posts/${this.$route.params.id}`;
      await axios
        .delete(url)
        .then(() => {})
        .catch(() => {});
    },
  },

  async created() {
    this.currentUserId = JSON.parse(localStorage["user"])?.id;

    this.postId = this.$route.params.id;

    let url = `http://localhost:8000/api/posts/${this.postId}`;

    this.editLink = `/edit_post/${this.$route.params.id}`;

    await this.getComments();

    await axios
      .get(url)
      .then((response) => {
        this.post = response.data;
        this.postAuthorId = response?.data?.user?.id;
        this.postAuthor = response?.data?.user?.name;
        this.postTitle = response?.data?.title;
        this.postText = response?.data?.text;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style>
.posts-container {
  margin-top: 20px;
}

.comment-header {
  display: flex;
  justify-content: space-between;
}

.comment-container {
  margin-top: 10px;
  margin-bottom: 20px;
}

.comment-action-btns {
  margin-top: 20px;
  display: flex;
}

.spacing-10 {
  width: 10px;
}

.post-actions {
  display: flex;
}
</style>
