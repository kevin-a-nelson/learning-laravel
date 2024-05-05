<template>
  <div class="container col-lg-6">
    <form class="form-container" @submit.prevent="onSubmit" novalidate>
      <fieldset>
        <legend>{{ mode === "create" ? "Create Post" : "Edit Post" }}</legend>
        <div>
          <label for="exampleInputName1" class="form-label mt-4">Title</label>
          <input
            v-model="postTitle"
            type="name"
            class="form-control"
            id="exampleInputName1"
            aria-describedby="nameHelp"
          />
        </div>
        <div>
          <label for="exampleTextarea" class="form-label mt-4">Text</label>
          <textarea
            v-model="postText"
            class="post-form form-control"
            id="exampleTextarea"
            rows="3"
          ></textarea>
        </div>
        <div class="login-failed-container" v-if="false">
          <p class="text-danger">Unable to create account</p>
        </div>
        <div class="submit-btn-container">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </fieldset>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import router from "../routes/routes.js";

export default {
  name: "CreatePost",

  props: {
    mode: String,
  },

  data() {
    return {
      postText: "",
      postTitle: "",
      createPostFailed: false,
    };
  },

  async mounted() {
    if (this.mode === "edit") {
      await this.getPost();
    }
  },

  methods: {
    async onSubmit() {
      if (this.mode === "edit") {
        await this.editPost();
      } else {
        await this.createPost();
      }
    },
    async getPost() {
      let url = `http://localhost:8000/api/posts/${this.$route.params.id}`;
      await axios
        .get(url)
        .then((response) => {
          if (response?.data) {
            this.postText = response?.data?.text;
            this.postTitle = response?.data?.title;
          }
        })
        .catch((error) => {
          this.createPostFailed = true;
          console.log(error);
        });
    },
    async editPost() {
      let url = `http://localhost:8000/api/posts/${this.$route.params.id}`;
      let newPost = {
        text: this.postText,
        title: this.postTitle,
      };

      await axios
        .post(url, newPost)
        .then(() => {
          router.push(`/posts/${this.$route.params.id}`);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async createPost() {
      let url = "http://localhost:8000/api/posts";
      let newPost = {
        user_id: JSON.parse(localStorage?.user)?.id,
        text: this.postText,
        title: this.postTitle,
      };

      await axios
        .post(url, newPost)
        .then((response) => {
          if (response.data.code === 200) {
            this.postText = "";
            this.postTitle = "";
            router.push(`/posts/${response.data.post.id}`);
          } else {
            this.createPostFailed = true;
          }
        })
        .catch((error) => {
          this.createPostFailed = true;
          console.log(error);
        });
    },
  },
};
</script>

<style>
.form-container {
  margin-top: 20px;
  margin-bottom: 15px;
}

.post-form {
  height: 200px;
}

.submit-btn-container {
  margin: 20px 0;
  /* margin: 10px 0 10px 0; */
}
</style>
