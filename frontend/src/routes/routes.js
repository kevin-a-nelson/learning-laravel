
import Posts from "../components/Posts";
import Login from '../components/Login';
import Register from '../components/Register';
import CreatePost from '../components/CreatePost';
import ViewPost from '../components/ViewPost';
import PostDeleted from '../components/PostDeleted';
import { createRouter, createWebHistory } from 'vue-router'


const routes = [
    {
        name: 'Posts',
        path: '/',
        component: Posts
    },
    {
        name: 'Login',
        path: '/login',
        component: Login
    },
    {
        name: 'Register',
        path: '/register',
        component: Register
    },
    {
        name: 'CreatePost',
        props: { mode: 'create' },
        path: '/create_post',
        component: CreatePost,
    },
    {
        name: 'EditPost',
        props: { mode: 'edit' },
        path: '/edit_post/:id',
        component: CreatePost,
    },
    {
        name: 'ViewPost',
        path: '/posts/:id',
        component: ViewPost,
    },
    {
        name: 'PostDeleted',
        path: '/post_deleted',
        component: PostDeleted,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;