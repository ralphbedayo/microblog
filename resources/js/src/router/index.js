import Vue from 'vue';
import Router from 'vue-router'


Vue.use(Router);


export default new Router({
    routes: [
        {
            path: '/admin',
            name: 'Admin Dashboard',
            //component: PlayerContainer
        },
        {
            path: '/blog/:id',
            name: 'Blog Detail',
            // component: PlayerContainer
        },
        {
            path: '/',
            name: 'Home',
            // component: PlayerContainer
        },
    ]
})

