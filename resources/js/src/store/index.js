import axios from 'axios'
import Vue from 'vue'
import Vuex from 'vuex'
import VuexORM from '@vuex-orm/core'
import VuexORMAxios from '@vuex-orm/plugin-axios'
import Blog from "../models/Blog";
import User from "../models/User";
import Category from "../models/Category";

Vue.use(Vuex);
VuexORM.use(VuexORMAxios, { axios });

const database = new VuexORM.Database();

database.register(Blog);
database.register(User);
database.register(Category);

const store = new Vuex.Store({
    plugins: [VuexORM.install(database)],
    state: {
        authenticated: false,
        auth_user: {}
    },
    mutations: {
        setAuthentication(state, bStatus) {
            state.authenticated = bStatus;
        },
        setAuthUser(state, oUser) {
            state.auth_user = oUser
        }
    }
});

export const namespaced = true;

export default store;
