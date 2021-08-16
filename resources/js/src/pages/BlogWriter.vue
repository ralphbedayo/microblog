<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <div style="padding-top: 100px">
                <div class="row">
                    <div class="col-8 offset-2">
                        <div class="row">
                            <div class="d-flex justify-content-start">
                                <h1> {{ is_create ? 'Create Blog' : 'Edit Blog'}}</h1>
                            </div>
                        </div>
                        <div class="row shadow rounded rounded-3 p-3 py-5 justify-content-around">
                            <form action="" v-on:submit.prevent="submitBlog">
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="title-label"> Title </span>
                                        <input type="text" class="form-control" placeholder="Write a good title here"
                                               aria-label="Write a good title here" aria-describedby="title-label"
                                               minlength="5" maxlength="150"
                                               v-model="sTitle"
                                        >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="categorySelect">Category</label>
                                        <select class="form-select" id="categorySelect" v-model="iCategoryId">
                                            <option disabled value="">Select Category</option>
                                            <option :value="oCategory.id" v-for="(oCategory, mKey) in oCategories"> {{
                                                _.upperFirst(oCategory.title)}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="contentTextArea" class="form-label">Content</label>
                                        <textarea minlength="10" maxlength="5000" class="form-control"
                                                  id="contentTextArea"
                                                  rows="5" v-model="sContent"
                                                  placeholder="Enter your ideas here"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success mx-4"> Submit</button>
                                        <router-link :to="is_create ? '/' : '/blog/' + this.id"
                                                     class="btn btn-outline-secondary mx-4"> Cancel
                                        </router-link>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</template>
<script>
    import Navbar from "../components/navbar/Navbar";
    import User from "../models/User";
    import {ADMIN_USER_TYPE, OK_STATUS} from "../constants/common";
    import Category from "../models/Category";
    import Blog from "../models/Blog";

    export default {
        name: 'BlogWriter',
        components: {Navbar},
        props: ['is_create', 'id'],
        data() {
            // @todo replace html validation with Vue validation
            return {
                oAuthUser: {},
                oCategories: {},
                sTitle: '',
                sContent: '',
                iCategoryId: 1,
            }
        },
        methods: {
            async submitBlog() {
                let oBlogData = {
                    title: this.sTitle,
                    content: this.sContent,
                    category_id: this.iCategoryId,
                    author_id: this.oAuthUser.id,
                };

                let oResponse = this.is_create ? await Blog.createBlog(oBlogData) : await Blog.updateBlog(this.id, oBlogData);

                if (oResponse.status === OK_STATUS) {
                    let iNewBlogId = oResponse.data.data.id;

                    await this.$router.push({path: '/blog/' + iNewBlogId});
                }
            },
            async setBlogData() {
                let oBlogItem = await Blog.fetchById(this.id);

                this.sTitle = oBlogItem.title;
                this.sContent = oBlogItem.content;
                this.iCategoryId = oBlogItem.category_id;
            }
        },
        async beforeCreate() {
            this.oAuthUser = await User.getAuthUser();

            if (this.oAuthUser.user_type === ADMIN_USER_TYPE) {
                window.location.href = '/admin';
            }
        },
        async beforeMount() {
            this.oCategories = await Category.fetchAll();

            if (this.is_create === false) {
                this.setBlogData();
            }
        }
    }

</script>
<style scoped></style>
