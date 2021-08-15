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
                    <div class="d-flex justify-content-center">
                        <div class="w-75  shadow p-3 rounded rounded-3">
                            <form action="#" v-on:submit.prevent="search">
                                <h3>Search and Sort</h3>
                                <div class="row">
                                    <div class="row">
                                        <div class="d-flex justify-content-between">
                                            <div class="input-group mb-3" style="width: 45%;">
                                                <span class="input-group-text">Search By</span>
                                                <select class="form-select" id="searchFieldOptions"
                                                        v-model="sSearchField">
                                                    <option disabled value="">Select Field</option>
                                                    <option :value="sSearchFieldOriginal"
                                                            v-for="(sSearchFieldAlias, sSearchFieldOriginal) in oSearchFieldOptions">
                                                        {{sSearchFieldAlias}}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3" style="width: 45%;">
                                                <input type="text" class="form-control" placeholder="Search"
                                                       aria-label="Search"
                                                       v-model="sSearchValue"
                                                       aria-describedby="basic-addon2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex justify-content-between">
                                            <div class="input-group mb-3" style="width: 45%;">
                                                <span class="input-group-text">Order By</span>
                                                <select class="form-select" id="orderByOptions" v-model="sOrderByValue">
                                                    <option disabled value="">Select Order</option>
                                                    <option :value="sOrderByField"
                                                            v-for="(sOrderByAlias, sOrderByField) in oOrderByOptions">
                                                        {{sOrderByAlias}}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="input-group mb-3" style="width: 45%;">
                                                <span class="input-group-text">Sort By</span>
                                                <select class="form-select" id="sortByOptions" v-model="sSortByValue">
                                                    <option disabled value="">Select Sort Field</option>
                                                    <option :value="sSortByField"
                                                            v-for="(sSortByAlias, sSortByField) in oSortByOptions">
                                                        {{sSortByAlias}}
                                                    </option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="row mb-2">
                                                    <strong>Categories: </strong>
                                                </div>
                                                <div class="row px-2 mb-2">
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                            v-on:click="checkAllCategory">Check All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="row">
                                                    <div class="form-check col-3"
                                                         v-for="(oCategory, mKey) in oCategories">
                                                        <input class="form-check-input" type="checkbox"
                                                               :id="'cb_' + oCategory.title" :value="oCategory.id"
                                                               v-model="oCategoriesCheckedValue[oCategory.id]"
                                                        >
                                                        <label class="form-check-label" :for="'cb_' + oCategory.title">{{_.upperFirst(oCategory.title)}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success w-25"> Go</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
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

    export default {
        name: "Home",
        components: {BlogItem, Navbar},
        data() {
            return {
                oUser: User,
                bIsAuthenticated: store.state.authenticated,
                oBlogItems: {},
                oCategories: {},
                iLimit: 10,
                iPage: 1,
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
                },
                sSearchField: 'title',
                sSearchValue: '',
                sSortByValue: 'desc',
                sOrderByValue: 'created_at',
                oCategoriesCheckedValue: {
                    1: true,
                    2: true,
                    3: true,
                    4: true,
                    5: true,
                    6: true,
                    7: true,
                    8: true,
                    9: true,
                    10: true,
                }
            }
        },
        methods: {
            setSearchParams() {
                this.oSearchParams['limit'] = this.iLimit;
                this.oSearchParams['page'] = this.iPage;
            },
            checkAllCategory() {
                for (const [mKey, oCategory] of Object.entries(this.oCategories)) {
                    this.oCategoriesCheckedValue[oCategory.id] = true;
                }
            },
            async search() {
                let sL5SearchString = this.setSearchFieldParam();
                let oSortAndOrderParam = this.setSortAndOrderParam();
                let oPagination = {page: this.iPage, limit: this.iLimit};
                sL5SearchString += this.setCategorySearchParam();

                this.oBlogItems = await Blog.fetch({search: sL5SearchString, ...oSortAndOrderParam, ...oPagination});
            },
            setSearchFieldParam() {
                if (this.sSearchField.length === 0 || this.sSearchValue.length === 0) {
                    return '';
                }
                return this.sSearchField + ':' + this.sSearchValue + ';';
            },
            setSortAndOrderParam() {
                return {sortedBy: this.sSortByValue, orderBy: this.sOrderByValue};
            },
            setCategorySearchParam() {
                let sCategoryIdSearch = '';

                for (const [sCategoryId, bChecked] of Object.entries(this.oCategoriesCheckedValue)) {
                    if (bChecked) {
                        sCategoryIdSearch += sCategoryId + ',';
                    }
                }


                return 'category_id:' + sCategoryIdSearch.slice(0, -1);
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
            this.setSearchParams();
            this.oCategories = await Category.fetchAll();
            this.search();
            this.checkAllCategory();
        }
    }
</script>

<style scoped>
    .blog-table {
        padding: 15px 50px;
    }

</style>
