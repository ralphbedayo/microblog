import {Model} from "@vuex-orm/core";

export default class Blog extends Model {
    static entity = 'blog';

    static primaryKey = 'id';
}
