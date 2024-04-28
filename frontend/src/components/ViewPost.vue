<template>
    <div class="posts-container">
        <div class="container col-lg-6">
            <div class="card border-primary mb-3">
                <div class="card-header">{{ postAuthor }}</div>
                <div class="card-body">
                    <h4 class="card-title">{{ postTitle }}</h4>
                    <p class="card-text">{{ postText }}</p>
                    <div class="post-actions" v-if="currentUserId === postAuthorId">
                        <router-link class="nav-link active" :to="editLink"> <a href="#" class="card-link">Edit</a>
                        </router-link>
                        <span>&ensp;|&ensp;</span>
                        <router-link class="nav-link active" @click="deletePost" to="/post_deleted"> <a href="#"
                                class="card-link">Delete</a> </router-link>
                    </div>
                </div>
            </div>
            <div>
                <label for="exampleTextarea" class="form-label mt-4">Comments</label>
                <textarea class="form-control" id="exampleTextarea" rows="3" spellcheck="false"></textarea>
            </div>
            <div class="submit-btn-container">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
// import { routeLocationKey } from 'vue-router';


export default {
    name: 'ViewPost',

    data() {
        return {
            postAuthor: '',
            postTitle: '',
            postText: '',
            editLink: '',
            currentUserId: -1,
            postAuthorId: -1,
        }
    },

    methods: {
        async deletePost() {
            let url = `http://localhost:8000/api/posts/${this.$route.params.id}`
            await axios.delete(url)
                .then(() => {
                }).catch(() => {

                })
        }
    },

    async created() {

        this.currentUserId = JSON.parse(localStorage['user'])?.id;

        let url = `http://localhost:8000/api/posts/${this.$route.params.id}`

        this.editLink = `/edit_post/${this.$route.params.id}`

        await axios.get(url).then(response => {
            this.postAuthorId = response?.data?.user?.id
            this.postAuthor = response?.data?.user?.name
            this.postTitle = response?.data?.title
            this.postText = response?.data?.text
        }).catch(error => {
            console.log(error)
        })
    },
}

</script>

<style>
.posts-container {
    margin-top: 20px;
}

.post-actions {
    display: flex;
}
</style>