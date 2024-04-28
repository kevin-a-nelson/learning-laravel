<template>
    <div class="posts-container">
        <div class="container col-lg-6">
            <!-- <button type="button" class="btn btn-primary btn-lg">Large button</button> -->
            <div v-if="isLoggedIn" class="post-actions create-post-btn-container">
                <router-link class="nav-link active" to="/create_post">
                    <a href="#" class="card-link">Create Post</a>
                </router-link> &ensp;|&ensp;
                <a href="#" @click="getMyPosts" class="card-link">My Posts</a> &ensp;|&ensp;
                <a href="#" @click="getPosts" class="card-link">All Posts</a>
            </div>
            <div v-for="post in posts" :key="post.id" class="card border-primary mb-3">
                <div class="flex card-header">
                    <span> {{ post.user.name }}</span>
                    <span> {{ post.created_at }} </span>
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ post.title }}</h4>
                    <p class="card-text">{{ post.text }}</p>
                    <a href="#" @click="() => viewPost(post.id)" class="card-link">View</a>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import axios from 'axios'
import router from '../routes/routes.js'

export default {
    name: 'Posts',
    data() {
        return {
            posts: [],
            isLoggedIn: false,
        }
    },
    created() {
        this.isLoggedIn = localStorage['user']
        this.getPosts();
    },
    methods: {
        async getMyPosts() {
            let userId = JSON.parse(localStorage['user'])?.id
            let url = `http://localhost:8000/api/posts?userId=${userId}`
            await axios.get(url).then(response => {
                this.posts = response.data
            }).catch(error => {
                console.log(error)
            })
        },

        async getPosts() {
            let url = 'http://localhost:8000/api/posts'
            await axios.get(url).then(response => {
                this.posts = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        viewPost(postId) {
            router.push(`/posts/${postId}`)
        },
    }
}

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