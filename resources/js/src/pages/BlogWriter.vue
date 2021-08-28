<template>
    <div>
        <navbar :auth_user="this.oAuthUser"></navbar>
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
                            <form action="" v-on:submit.prevent="submitBlog" novalidate>
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="title-label"> Title </span>
                                        <input type="text" class="form-control" placeholder="Write a good title here"
                                               aria-label="Write a good title here" aria-describedby="title-label"
                                               minlength="5" maxlength="150"
                                               :class="{'form-control': true, 'is-invalid': $v.sTitle.$error}"
                                               v-model.trim="$v.sTitle.$model"
                                        >
                                        <div class="invalid-feedback" v-if="!$v.sTitle.required"> Title is required.</div>
                                        <div class="invalid-feedback" v-if="!$v.sTitle.minLength"> Title must have at least {{$v.sTitle.$params.minLength.min}} letters.</div>
                                        <div class="invalid-feedback" v-if="!$v.sTitle.maxLength"> Title have a limit of {{$v.sTitle.$params.maxLength.max}} letters.</div>
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
                                        <textarea minlength="5" maxlength="30000" class="form-control"
                                                  id="contentTextArea"
                                                  rows="5"
                                                  placeholder="Enter your ideas here"
                                                  :class="{'form-control': true, 'is-invalid': $v.sContent.$error}"
                                                  v-model.trim="$v.sContent.$model"
                                        >
                                        </textarea>
                                        <div class="invalid-feedback" v-if="!$v.sContent.required"> Content is required.</div>
                                        <div class="invalid-feedback" v-if="!$v.sContent.minLength"> Content must have at least {{$v.sContent.$params.minLength.min}} characters.</div>
                                        <div class="invalid-feedback" v-if="!$v.sContent.maxLength"> Content have a limit of {{$v.sContent.$params.maxLength.max}} characters.</div>
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
    import {ADMIN_USER_TYPE, OK_STATUS, SYSTEM_ERROR_MESSAGE} from "../constants/common";
    import Category from "../models/Category";
    import Blog from "../models/Blog";
    import {maxLength, minLength, required} from "vuelidate/lib/validators";
    import {AuthUserMixin} from "../mixins/AuthUserMixin";

    export default {
        name: 'BlogWriter',
        components: {Navbar},
        props: ['is_create', 'id'],
        mixins: [AuthUserMixin],
        data() {
            return {
                oCategories: {},
                sTitle: '',
                sContent: '',
                iCategoryId: 1,
            }
        },
        validations: {
            sTitle: {
                required,
                minLength: minLength(5),
                maxLength: maxLength(100),
            },
            sContent: {
                required,
                minLength: minLength(5),
                maxLength: maxLength(25000),
            }
        },
        methods: {
            async submitBlog() {
                this.$v.$touch();
                if (this.$v.$invalid || this.bUsernameExists) {
                    return;
                }

                let oBlogData = {
                    title: this.sTitle,
                    content: this.sContent,
                    category_id: this.iCategoryId,
                    author_id: this.oAuthUser.id,
                };


                this.$isLoading(true);
                try {
                    let oResponse = this.is_create ? await Blog.createBlog(oBlogData) : await Blog.updateBlog(this.id, oBlogData);

                    if (oResponse.status === OK_STATUS) {
                        let iNewBlogId = oResponse.data.data.id;

                        await this.$router.push({path: '/blog/' + iNewBlogId});
                    }
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }
                this.$isLoading(false);
            },
            async setBlogData() {

                this.$isLoading(true);
                try {
                    let oBlogItem = await Blog.fetchById(this.id);

                    this.sTitle = oBlogItem.title;
                    this.sContent = oBlogItem.content;
                    this.iCategoryId = oBlogItem.category_id;
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }

                this.$isLoading(false);
            }
        },
        async beforeMount() {
            this.$isLoading(true);
            this.oAuthUser = await this.getAuthUser();

            try {
                this.oCategories = await Category.fetchAll();

                if (this.is_create === false) {
                    await this.setBlogData();
                }
            } catch (e) {
                alert(SYSTEM_ERROR_MESSAGE);
            }
            this.$isLoading(false);
        }
    }

</script>
<style scoped></style>
