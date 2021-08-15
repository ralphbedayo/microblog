import Vue from 'vue';
import Router from 'vue-router'
import Home from "../pages/Home";
import Admin from "../pages/Admin";
import BlogPost from "../pages/BlogPost";


Vue.use(Router);


export default new Router({
    routes: [
        {
            path: '/admin',
            name: 'Admin Dashboard',
            component: Admin
        },
        {
            path: '/blog/:id',
            name: 'Blog Detail',
            component: BlogPost
        },
        {
            path: '/',
            name: 'Home',
            component: Home
        }

    ],
    mode: 'history'
})

