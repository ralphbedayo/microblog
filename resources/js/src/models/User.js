import {Model} from "@vuex-orm/core";
import {ORDER_FIELD_CONVERSION} from "../constants/common";
import {sortCaseInsensitive} from "../lib/utils";


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

        let oUsers = this.query().orderBy(oParams.orderBy, oParams.sortedBy).all();


        // Repeating sorting due to Vuex ORM issue https://github.com/vuex-orm/vuex-orm/issues/702
        let oSortedData =  sortCaseInsensitive(oUsers, oParams.orderBy, oParams.sortedBy);

        return {data: oSortedData, meta: oResult.response.data.meta};
    }

    static async fetchById(iId, oParams = {}) {
        this.deleteAll();

        await this.api().get('/' + iId, {params: {...oParams}});

        return this.find(iId);
    }

    static async createUser(oData) {
        let oResult = await this.api().post('', oData);

        return oResult.response;
    }

    static async updateUser(iId, oData) {
        delete oData.username;

        let oResult = await this.api().put('/' + iId, oData);

        return oResult.response;
    }

    static async deleteUser(iId) {
        let oResult = await this.api().delete('/' + iId);

        return oResult.response.status;
    }

}
