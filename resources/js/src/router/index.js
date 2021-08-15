import Vue from 'vue';
import Router from 'vue-router'
import Home from "../pages/Home";
import Admin from "../pages/Admin";
import BlogPost from "../pages/BlogPost";
import BlogWriter from "../pages/BlogWriter";


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
            path: '/blog/:id/edit',
            name: 'Edit Blog',
            component: BlogWriter,
            props: route => ({is_create: false, id: route.params.id })
        },
        {
            path: '/create',
            name: 'Create Blog',
            component: BlogWriter,
            props: {is_create: true}
        },
        {
            path: '/',
            name: 'Home',
            component: Home
        }

    ],
    mode: 'history'
})

