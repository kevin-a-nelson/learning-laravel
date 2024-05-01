<template>
  <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"> {{ title }}</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarColor01"
        aria-controls="navbarColor01"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link class="nav-link active" to="/"> Posts </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" to="/friends">
              Friends
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" to="/login">
              Login
            </router-link>
          </li>
          <router-link class="nav-link active" @click="logout" to="/logged_out">
            Logout
          </router-link>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
// import router from "@/routes/routes";

export default {
  name: "Header",
  props: {
    title: String,
  },
  methods: {
    logout() {
      localStorage.clear();
    },
  },
  components: {},
};
</script>
