<template>
    <div>
        <navbar></navbar>
        <div class="container" style="padding-top: 75px">
            <div class="row">
                <h2>Manager Users</h2>
            </div>
            <div class="row mt-5">
                <search
                    :is_blog_home="false"
                    default_search_field="username"
                    default_order_value="created_at"
                    default_sort_value="desc"
                    :search_field_options="oSearchFieldOptions"
                    :order_by_options="oOrderByOptions"
                    v-model="oSearchParams"
                ></search>
            </div>
            <div class="row mt-5">
                <div class="d-flex justify-content-end">
                    <pagination :current_page="iPage" v-model="iPage" :total_page="this.iTotalPage"></pagination>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">User Type</th>
                        <th scope="col">Created</th>
                        <th scope="col">Last Updated</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(oUser, mKey) in oUsers">
                        <td>{{oUser.id}}</td>
                        <td>{{oUser.name}}</td>
                        <td>{{oUser.username}}</td>
                        <td>{{_.upperFirst(oUser.user_type)}}</td>
                        <td>{{moment(oUser.created_at).format(sDateTimeFormat)}}</td>
                        <td>{{moment(oUser.updated_at).format(sDateTimeFormat)}}</td>
                        <td>
                            <div v-if="oUser.id !== oAuthUser.id">
                                <button class="btn btn-md btn-outline-primary"><i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-md btn-danger"><i class="bi bi-trash-fill"></i></button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</template>
<script>
    import User from "../models/User";
    import {ADMIN_USER_TYPE, SHORT_DATE_TIME_FORMAT} from "../constants/common";
    import Navbar from "../components/navbar/Navbar";
    import Search from "../components/common/Search";
    import Pagination from "../components/common/Pagination";

    export default {
        name: "Admin",
        components: {Pagination, Navbar, Search},
        data() {
            return {
                iLimit: 10,
                iPage: 1,
                iTotalPage: 1,
                oSearchFieldOptions: {
                    'id': 'User ID',
                    'username': 'Username',
                    'name': 'Name'
                },
                oOrderByOptions: {
                    'id': 'User ID',
                    'username': 'Username',
                    'name': 'Name',
                    'created_at': 'Date Created',
                    'updated_at': 'Date Last Updated'
                },
                oSearchParams: {},
                oAuthUser: {},
                oUsers: {},
                sDateTimeFormat: SHORT_DATE_TIME_FORMAT
            };

        },
        methods: {
            async search() {
                let oPagination = {page: this.iPage, limit: this.iLimit};
                let oSearchParams = this.oSearchParams;

                let oResponse = await User.fetchAll({...oSearchParams, ...oPagination});
                this.oUsers = oResponse.data;
                this.iPage = oResponse.meta.pagination.current_page;
                this.iTotalPage = oResponse.meta.pagination.total_pages;
            }
        },
        watch: {
            oSearchParams: function (val) {
                this.search();
            },
            iPage: function (val) {
                this.search();
            }
        },
        async beforeCreate() {
            this.oAuthUser = await User.getAuthUser();

            if (this.oAuthUser.user_type !== ADMIN_USER_TYPE) {
                window.location.href = '/';
            }
        },
        beforeMount() {
        }
    }
</script>

<style scoped></style>
