import {Model} from "@vuex-orm/core";
import {ORDER_FIELD_CONVERSION} from "../constants/common";


export default class User extends Model {
    static entity = 'user';

    static primaryKey = 'id';

    static apiConfig = {
        baseURL: '/api/users',
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

    static async fetchAll(oParams = {}) {
        this.deleteAll();

        oParams.searchJoin = 'and';

        let oResult = await this.api().get('', {params: oParams});

        oParams.orderBy = ORDER_FIELD_CONVERSION[oParams.orderBy] ?? oParams.orderBy;

        return {data: this.query().orderBy(oParams.orderBy, oParams.sortedBy).all(), meta: oResult.response.data.meta};
    }

    static async fetchById(iId, oParams = {}) {
        this.deleteAll();

        await this.api().get('/' + iId, {params: {...oParams}});

        return this.find(iId);
    }

}
