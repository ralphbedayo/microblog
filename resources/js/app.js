import Vue from 'vue'
import App from './src/App.vue'
import router from './src/router';
import store from "@/store";
import moment from 'moment';
import _ from 'lodash';
import Vuelidate from 'vuelidate';


// Globals
import 'bootstrap/dist/css/bootstrap.css'
import './polyfill';

Vue.use(Vuelidate);
Vue.config.productionTip = false;


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
