<template>
  <div class="container col-lg-4">
    <div class="bs-component">
      <div class="alert alert-dismissible alert-danger">
        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        {{ message }}
      </div>
      <router-link class="nav-link active" to="/">
        <a href="#" class="card-link">Go Home</a>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "MessagePage",
  props: {
    message: String,
  },
};
</script>

<style></style>
