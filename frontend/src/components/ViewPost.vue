<template>
  <div class="posts-container">
    <div class="container col-lg-6">
      <Post :post="post" :currentUserId="currentUserId" />
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
import Post from "../components/Post.vue";

export default {
  name: "ViewPost",

  components: {
    Comment,
    NewCommentForm,
    Post,
  },

  data() {
    return {
      postAuthor: "",
      post: {},
      postTitle: "",
      postText: "",
      commentText: "",
      commentBeingEdited: -1,
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
  },

  async created() {
    this.currentUserId = JSON.parse(localStorage["user"])?.id;

    this.postId = this.$route.params.id;

    let url = `http://localhost:8000/api/posts/${this.postId}`;

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
