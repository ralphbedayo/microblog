import Vue from 'vue'
import App from './src/App.vue'
import router from './src/router';
import store from "@/store";
import moment from 'moment';
import _ from 'lodash';
import Vuelidate from 'vuelidate';
import loading from 'vuejs-loading-screen';

// Globals
import 'bootstrap/dist/css/bootstrap.css'
import './polyfill';

Vue.use(Vuelidate);
Vue.use(loading, {
    bg: 'rgba(0,0,0,0.2)',
    slot: '<div class="px-5 py-3"> <div class="spinner-border text-primary" role="status" style="width: 5rem; height: 5rem;"></div> </div>'
});
Vue.config.productionTip = false;


Vue.prototype.moment = moment;
Vue.prototype._ = _;

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    components: {App},
    template: '<App/>',
    store: store
});
