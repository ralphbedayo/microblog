import {Model} from "@vuex-orm/core";


export default class User extends Model {
    static entity = 'user';

    static primaryKey = 'id';

    static apiConfig = {
        baseURL: '/api/user',
        dataTransformer: (response) => {
            return response.data.data;
        }
    };

    static fields() {
        return {
            id: this.number(0),
            name: this.string(''),
            username: this.string(''),
            user_type: this.string(''),
            created_at: this.string(''),
            updated_at: this.string(''),
        };
    }


    static async getAuthUser() {
        let oAuthUser = await User.fetchAuthUser(true);
        this.store().commit('setAuthentication', true);
        this.store().commit('setAuthUser', oAuthUser);

        return oAuthUser;
    }


    static async fetchAuthUser(bForced = false, oParams = {}) {

        if (bForced || this.store().state.authenticated === false) {
            let oResponse = await this.api().get('/me', {baseURL: '/api'});
            let iResponseDataId = oResponse.response.data.data.id;

            return this.find(iResponseDataId);
        }

        return this.find(this.store().state.auth_user.id);
    }

}
