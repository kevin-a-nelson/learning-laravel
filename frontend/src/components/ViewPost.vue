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
                <textarea class="form-control" v-model="commentText" id="exampleTextarea" rows="3"
                    spellcheck="false"></textarea>
            </div>
            <div class="submit-btn-container">
                <button @click="createComment" class="btn btn-primary">Submit</button>
            </div>
            <div v-for="comment in comments" :key="comment.id">
                <div class="comment-container card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Card title</h4> -->
                        <div class="comment-header">
                            <h6>{{ comment.user.name }}</h6>
                            <p class="card-subtitle mb-2 text-muted">{{ comment.created_at }}</p>
                        </div>
                        <div v-if="comment.id === commentBeingEdited">
                            <textarea v-model="newCommentText" class="form-control" id="exampleTextarea"
                                rows="3"></textarea>
                            <div class="comment-action-btns">
                                <button @click="() => updateComment(comment)" class="btn btn-primary">Submit</button>
                                <div class="spacing-10"></div>
                                <button @click="() => cancelCommentEdit()" class="btn btn-primary">Cancel</button>
                            </div>
                        </div>
                        <div v-else>
                            <p class="card-text">{{ comment.text }}</p>

                            <div class="post-actions" v-if="currentUserId === comment.userId">
                                <a href="#" @click="() => setCommentBeingEdited(comment)" class="card-link">Edit</a>
                                <span>&ensp;|&ensp;</span>
                                <a @click="() => deleteComment(comment.id)" href="#" class="card-link">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
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
            post: {},
            postTitle: '',
            postText: '',
            commentText: '',
            commentBeingEdited: -1,
            editLink: '',
            currentUserId: -1,
            postAuthorId: -1,
            postId: -1,
            newCommentText: '',
            comments: [],
        }
    },

    methods: {
        async updateComment(comment) {
            let url = `http://localhost:8000/api/comments/${comment.id}`

            let newComment = {
                text: this.newCommentText
            }

            await axios.post(url, newComment)
                .then(() => {
                    this.newCommentText = ''
                    this.commentBeingEdited = -1
                }).catch(() => {
                })

            await this.getComments()
        },

        cancelCommentEdit() {
            this.newCommentText = ''
            this.commentBeingEdited = -1
        },
        setCommentBeingEdited(comment) {
            // console.log(comment.text)
            this.newCommentText = comment.text
            // this.newCommentText = comment.text
            this.commentBeingEdited = comment.id
        },
        async deleteComment(commentId) {
            let url = `http://localhost:8000/api/comments/${commentId}`

            await axios.delete(url)
                .then(() => {
                }).catch(() => {
                })

            await this.getComments()
        },

        async getComments() {
            let url = `http://localhost:8000/api/comments?postId=${this.postId}`

            await axios.get(url)
                .then(response => {
                    console.log(response)
                    console.log(url)
                    this.comments = response.data
                }).catch(() => {

                })
        },

        async createComment() {
            let url = `http://localhost:8000/api/comments`
            let userId = JSON.parse(localStorage['user'])?.id
            let comment = {
                'text': this.commentText,
                'userId': userId,
                'postId': this.$route.params.id
            }

            await axios.post(url, comment)
                .then(() => {
                    this.commentText = ''
                }).catch(() => {

                })

            await this.getComments();
        },

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

        this.postId = this.$route.params.id

        let url = `http://localhost:8000/api/posts/${this.postId}`

        this.editLink = `/edit_post/${this.$route.params.id}`

        await this.getComments();

        await axios.get(url).then(response => {
            this.post = response.data
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