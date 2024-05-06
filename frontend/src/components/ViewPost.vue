<template>
  <div class="posts-container">
    <div class="container col-lg-6">
      <div class="back-btn">
        <RouterLink to="/">Back</RouterLink>
      </div>
      <Post
        :post="post"
        :currentUser="currentUser"
        :showView="false"
        :showDelete="true"
        :showEdit="true"
      />
      <NewCommentForm v-if="currentUser?.id" @create:comment="createComment" />
      <div v-for="comment in comments" :key="comment.id">
        <Comment
          :comment="comment"
          :commentBeingEdited="commentBeingEdited"
          :currentUser="currentUser"
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
      currentUser: {},
      postAuthorId: -1,
      postId: -1,
      newCommentText: "",
      comments: [],
    };
  },

  methods: {
    async updateComment(comment) {
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
      this.commentBeingEdited = -1;
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

  async mounted() {
    try {
      this.currentUser = JSON.parse(localStorage["user"]);
    } catch {
      this.currentUser = {};
    }

    this.postId = this.$route.params.id;

    let url = `http://localhost:8000/api/posts/${this.postId}`;

    await this.getComments();

    await axios
      .get(url)
      .then((response) => {
        this.post = response?.data?.data;
        this.postAuthorId = this.post?.user?.id;
        this.postAuthor = this.post?.user?.name;
        this.postTitle = this.post?.title;
        this.postText = this.post?.text;
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

.back-btn {
  margin-bottom: 10px;
}
</style>
