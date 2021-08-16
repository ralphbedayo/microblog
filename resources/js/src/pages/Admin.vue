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
                    default_order_value="updated_at"
                    default_sort_value="desc"
                    :search_field_options="oSearchFieldOptions"
                    :order_by_options="oOrderByOptions"
                    v-model="oSearchParams"
                ></search>
            </div>
            <div class="row mt-5">
                <div class="d-flex justify-content-between">
                    <div>
                        <router-link to="/admin/create" class="btn btn-success "> Add User
                        </router-link>
                    </div>
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
                                <router-link :to="'/admin/users/'+oUser.id +'/update'"
                                             class="btn btn-md btn-outline-primary"><i class="bi bi-pencil-square"></i>
                                </router-link>
                                <button class="btn btn-md btn-danger" v-on:click="deleteUser(oUser.id)"><i
                                    class="bi bi-trash-fill"></i></button>
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
    import {
        ADMIN_USER_TYPE,
        DELETE_RESOURCE_CONFIRM_MESSAGE,
        OK_STATUS,
        SHORT_DATE_TIME_FORMAT, SYSTEM_ERROR_MESSAGE
    } from "../constants/common";
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
                    'user_type': 'User Type',
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

                try {
                    let oResponse = await User.fetchAll({...oSearchParams, ...oPagination});
                    this.oUsers = oResponse.data;
                    this.iPage = oResponse.meta.pagination.current_page;
                    this.iTotalPage = oResponse.meta.pagination.total_pages;
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }
            },
            async deleteUser(iId) {
                if (confirm(DELETE_RESOURCE_CONFIRM_MESSAGE) === false) {
                    return;
                }

                try {
                    let iResponseCode = await User.deleteUser(iId);

                    if (iResponseCode === OK_STATUS) {
                        this.search();
                    }
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }

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
            // @todo refactor this block of code into mixin

            try {
                this.oAuthUser = await User.getAuthUser();

                if (this.oAuthUser.user_type !== ADMIN_USER_TYPE) {
                    window.location.href = '/';
                }
            } catch (e) {
                alert(SYSTEM_ERROR_MESSAGE);
            }
        },
    }
</script>

<style scoped></style>
