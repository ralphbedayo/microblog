import {Model} from "@vuex-orm/core";


export default class Comment extends Model {
    static entity = 'comment';

    static primaryKey = 'id';

    static apiConfig = {
        baseURL: '/api/comments',
        dataTransformer: (response) => {
            return response.data.data;
        }
    };

    static fields() {
        return {
            id: this.number(0),
            blog_id: this.number(0),
            comment_author_id: this.number(0),
            content: this.string(''),
        };
    }

    static async createComment(oData) {
        let oResult = await this.api().post('', oData);

        return oResult.response.status;
    }

    static async deleteComment(iId) {
        let oResult = await this.api().delete('/' + iId);

        return oResult.response.status;
    }

    static async updateComment(iId, oData) {
        let oResult = await this.api().put('/' + iId, oData);

        return oResult.response.status;
    }
}
