
import Posts from "../components/Posts";
import Login from '../components/Login';
import Register from '../components/Register';
import CreatePost from '../components/CreatePost';
import ViewPost from '../components/ViewPost';
import MessagePage from '../components/MessagePage';
import { createRouter, createWebHistory } from 'vue-router'
import FriendsPage from "@/components/FriendsPage.vue";


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
        name: 'Register',
        path: '/friends',
        component: FriendsPage
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
        name: 'MessagePage',
        props: { message: 'The post is now deleted.' },
        path: '/post_deleted',
        component: MessagePage,
    },
    {
        name: 'LoggedOut',
        props: { message: 'You are now logged out.' },
        path: '/logged_out',
        component: MessagePage,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;