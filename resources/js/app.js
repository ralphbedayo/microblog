import Vue from 'vue'
import App from './src/App.vue'
import router from './src/router';

import 'bootstrap/dist/css/bootstrap.css'
import store from "@/store";
import moment from 'moment';
import _ from 'lodash';

Vue.config.productionTip = false;

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css';

import './polyfill';

Vue.prototype.moment = moment;
Vue.prototype._ = _;

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    components: { App },
    template: '<App/>',
    store: store
});
