import {Model} from "@vuex-orm/core";

export default class Category extends Model {
    static entity = 'category';

    static primaryKey = 'id';

    static apiConfig = {
        baseURL: '/api/categories',
        dataTransformer: (response) => {
            return response.data.data;
        }
    };

    static fields() {
        return {
            id: this.number(0),
            title: this.string('')
        };
    }

    static async fetchAll(oParams = {}) {

        await this.api().get('/', {params: {...oParams}});

        return this.all();
    }
}
