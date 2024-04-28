<template>
  <div class="comment-container card">
    <div class="card-body">
      <div class="comment-header">
        <h6>{{ comment?.user?.name }}</h6>
        <p class="card-subtitle mb-2 text-muted">{{ comment.created_at }}</p>
      </div>
      <div v-if="comment.id === commentBeingEdited">
        <textarea
          :value="newComment.text"
          @input="updateCommentText"
          class="form-control"
          id="exampleTextarea"
          rows="3"
        ></textarea>
        <div class="comment-action-btns">
          <button
            @click="$emit('update:comment', newComment)"
            class="btn btn-primary"
          >
            Submit
          </button>
          <div class="spacing-10"></div>
          <button @click="() => onCancel()" class="btn btn-primary">
            Cancel
          </button>
        </div>
      </div>
      <div v-else>
        <p class="card-text">{{ comment.text }}</p>

        <div class="post-actions" v-if="currentUser?.id === comment.userId">
          <a
            href="#"
            @click="() => $emit('update:commentBeingEdited', comment)"
            class="card-link"
            >Edit</a
          >
          <span>&ensp;|&ensp;</span>
          <a
            @click="() => $emit('delete:comment', comment)"
            href="#"
            class="card-link"
            >Delete</a
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Comment",
  props: {
    comment: Object,
    commentBeingEdited: Number,
    currentUser: Object,
  },
  data() {
    return {
      newComment: {},
    };
  },

  methods: {
    updateCommentText(e) {
      this.newComment.text = e.target.value;
    },

    onCancel() {
      this.newComment = this.comment;
      this.$emit("update:commentBeingEdited", {});
    },
  },

  created() {
    this.newComment = this.comment;
  },
};
</script>

<style></style>
