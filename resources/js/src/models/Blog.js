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
            category: this.string(''),
            author: this.attr(null),
            author_name: this.string(''),
            created_at: this.string(''),
            updated_at: this.string(''),
        };
    }

    static async fetch(oParams = {}) {
        // deleteAll to refresh vuex database
        this.deleteAll();

        oParams['searchJoin'] = 'and';

        await this.api().get('', {params: oParams});

        oParams.orderBy = this.convertOrderByField(oParams.orderBy);

        console.log(oParams.orderBy);

        return this.query().orderBy(oParams.orderBy, oParams.sortedBy).all();
    }


    static async fetchById(iId, bForced = false, oParams = {}) {
        let iBlogId = parseInt(iId);

        if (bForced || !this.find(iBlogId)) {
            await this.api().get('/' + iId, {params: {...oParams}});
        }

        return this.query().whereId(iBlogId).withAllRecursive().first();
    }

    static convertOrderByField(sOrderBy) {
        return ORDER_FIELD_CONVERSION[sOrderBy] ?? sOrderBy;
    }
}
