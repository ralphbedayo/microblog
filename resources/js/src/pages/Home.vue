<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <div style="padding-top: 100px">
                <div class="row">
                    <div class="col-6">
                        <h1>Welcome to Blog Spotter </h1>
                        <h2 class="mb-3">where you can write, read and connect.</h2>
                        <p>It offers you easy and free ways to create and publish your thinking on any topic that you
                            want. </p>
                        <p>Go further with your ideas and opinions through blog spotter.</p>
                    </div>
                </div>

                <div class="row mt-5">
                    <search
                        is_blog_home="true"
                        default_search_field="title"
                        default_order_value="created_at"
                        default_sort_value="desc"
                        :search_field_options="oSearchFieldOptions"
                        :order_by_options="oOrderByOptions"
                        :categories="oCategories"
                        v-model="oSearchParams"
                    ></search>
                </div>
                <div class="row mt-5">
                    <div class="d-flex justify-content-end">
                        <pagination :current_page="this.iPage" :total_page="this.iTotalPage" v-model="iPage"></pagination>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="blog-table border-top border-1 border-secondary">
                    <div class="row blog-row d-flex justify-content-around">
                        <blog-item class_string="col-6 col-sm-3" v-for="(oBlogItem, mKey) in oBlogItems"
                                   :key="mKey" :blog="oBlogItem">
                        </blog-item>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import User from "../models/User";
    import store from "../store";
    import {ADMIN_USER_TYPE} from "../constants/common";
    import Navbar from "../components/navbar/Navbar";
    import BlogItem from "../components/home/BlogItem";
    import Blog from "../models/Blog";
    import Category from "../models/Category";
    import Search from "../components/common/Search";
    import Pagination from "../components/common/Pagination";

    export default {
        name: "Home",
        components: {Pagination, Search, BlogItem, Navbar},
        data() {
            return {
                oUser: User,
                bIsAuthenticated: store.state.authenticated,
                oBlogItems: {},
                oCategories: {},
                iLimit: 10,
                iPage: 1,
                iTotalPage: 1,
                oSearchParams: {},
                oSearchFieldOptions: {
                    'title': 'Title',
                    'author.name': 'Author Name'
                },
                oOrderByOptions: {
                    'title': 'Title',
                    'user:author_id|name': 'Author Name',
                    'category|category.title': 'Category',
                    'created_at': 'Date Created',
                    'updated_at': 'Date Last Updated'
                },
                oSortByOptions: {
                    'asc': 'Ascending',
                    'desc': 'Descending'
                }
            }
        },
        watch: {
            oSearchParams: function (val) {
                this.search();
            },
            iPage: function (val) {
                this.search()
            }
        },
        methods: {
            async search() {
                let oPagination = {page: this.iPage, limit: this.iLimit};
                let oSearchParams = this.oSearchParams;

                let oResponse = await Blog.fetch({...oSearchParams, ...oPagination});
                this.oBlogItems = oResponse.data;
                this.iPage = oResponse.meta.pagination.current_page;
                this.iTotalPage = oResponse.meta.pagination.total_pages;
            }
        },
        async beforeCreate() {
            if (store.state.authenticated === false) {
                let oAuthUser = await User.getAuthUser();

                if (oAuthUser.user_type === ADMIN_USER_TYPE) {
                    window.location.href = '/admin';
                }
            }
        },
        async beforeMount() {
            this.oCategories = await Category.fetchAll();
            this.search();
        }
    }
</script>

<style scoped>
    .blog-table {
        padding: 15px 50px;
    }

</style>
