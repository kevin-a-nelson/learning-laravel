<template>
  <div>
    <div>
      <label for="exampleTextarea" class="form-label mt-4">Comments</label>
      <textarea
        class="form-control"
        v-model="commentText"
        id="exampleTextarea"
        rows="3"
        spellcheck="false"
      ></textarea>
    </div>
    <div class="submit-btn-container">
      <button @click="onCreateComment" class="btn btn-primary">Submit</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "NewCommentForm",

  methods: {
    onCreateComment() {
      this.$emit("create:comment", this.commentText);
      this.commentText = "";
    },
  },

  data() {
    return {
      commentText: "",
    };
  },
};
</script>

<style></style>
