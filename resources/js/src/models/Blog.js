import {Model} from "@vuex-orm/core";
import {ORDER_FIELD_CONVERSION} from "../constants/common";

export default class Blog extends Model {
    static entity = 'blog';

    static primaryKey = 'id';

    static apiConfig = {
        baseURL: '/api/blogs',
        dataTransformer: (response) => {
            return response.data.data;
        }
    };

    static fields() {
        return {
            id: this.number(0),
            title: this.string(''),
            content: this.string(''),
            comments: this.attr(null),
            category: this.string(''),
            category_id: this.number(0),
            author: this.attr(null),
            author_id: this.number(0),
            author_name: this.string(''),
            created_at: this.string(''),
            updated_at: this.string(''),
        };
    }

    static async fetch(oParams = {}) {
        // deleteAll to refresh vuex database
        this.deleteAll();

        oParams['searchJoin'] = 'and';

        let oResult = await this.api().get('', {params: oParams});

        oParams.orderBy = this.convertOrderByField(oParams.orderBy);

        return {data: this.query().orderBy(oParams.orderBy, oParams.sortedBy).all(), meta: oResult.response.data.meta};
    }


    static async fetchById(iId, oParams = {include: 'comments'}) {
        let iBlogId = parseInt(iId);

        // deleteAll to refresh vuex database
        this.deleteAll();

        await this.api().get('/' + iId, {params: {...oParams}});

        return this.query().whereId(iBlogId).withAllRecursive().first();
    }

    static async createBlog(oData) {
        let oResult = await this.api().post('', oData);

        return oResult.response;
    }

    static async updateBlog(iId, oData) {
        let oResult = await this.api().put('/' + iId, oData);

        return oResult.response;
    }

    static async deleteBlog(iId) {
        let oResult = await this.api().delete('/' + iId);

        return oResult.response.status;
    }

    static convertOrderByField(sOrderBy) {
        return ORDER_FIELD_CONVERSION[sOrderBy] ?? sOrderBy;
    }
}
