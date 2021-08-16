<template>
    <div>
        <navbar></navbar>
        <div class="container" style="padding-top: 75px">
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="row">
                        <div class="d-flex justify-content-start">
                            <h1> {{ is_create ? 'Create User' : 'Update User'}}</h1>
                        </div>
                    </div>
                    <div class="row shadow rounded rounded-3 p-5 pb-3 justify-content-around">
                        <form action="" v-on:submit.prevent="saveUser">
                            <div class="row">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="name-label"> Name </span>
                                    <input type="text" class="form-control" placeholder="Enter full name"
                                           aria-label="Enter full name" aria-describedby="name-label"
                                           minlength="5" maxlength="150"
                                           required
                                           v-model="sName"
                                    >
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="username-label"> Username </span>
                                    <input type="text" class="form-control" placeholder="Enter an alphanumeric username"
                                           aria-label="Enter an alphanumeric username" aria-describedby="username-label"
                                           minlength="5" maxlength="50"
                                           required pattern="[a-zA-Z0-9]+"
                                           :disabled="is_create === false"
                                           v-model="sUsername"
                                    >
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="password-label"> Password </span>
                                    <input type="password" class="form-control"
                                           placeholder="Enter an alphanumeric password"
                                           aria-label="Enter an alphanumeric password" aria-describedby="password-label"
                                           minlength="5" maxlength="50"
                                           required pattern="[a-zA-Z0-9]+"
                                           v-model="sPassword"
                                    >
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="userTypeOptions">User Type</label>
                                    <select class="form-select" id="userTypeOptions" v-model="sUserType">
                                        <option disabled>Select User Type</option>
                                        <option v-for="sUserTypeDisplay in aUserTypes" :value="sUserTypeDisplay">
                                            {{ _.upperFirst(sUserTypeDisplay)}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success mx-4"> Submit</button>
                                    <router-link to="/admin"
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

</template>
<script>
    import {ADMIN_USER_TYPE, BLOGGER_USER_TYPE, OK_STATUS, SYSTEM_ERROR_MESSAGE} from "../constants/common";
    import Navbar from "../components/navbar/Navbar";
    import User from "../models/User";

    export default {
        name: 'UserEditor',
        components: {Navbar},
        props: ['is_create', 'id'],
        data() {
            // @todo replace html validation with Vue validation
            return {
                sUsername: '',
                sName: '',
                sPassword: '',
                sUserType: BLOGGER_USER_TYPE,
                aUserTypes: [ADMIN_USER_TYPE, BLOGGER_USER_TYPE],
                oValidationMessages: {}
            };
        },
        methods: {
            async saveUser() {
                let oUserData = {
                    'username': this.sUsername,
                    'name': this.sName,
                    'password': this.sPassword,
                    'user_type': this.sUserType,
                };

                try {
                    let oResponse = this.is_create ? await User.createUser(oUserData) : await User.updateUser(this.id, oUserData);

                    if (oResponse.status === OK_STATUS) {
                        await this.$router.push({path: '/admin'});
                    }
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }

            },
            async setUserData() {
                try {
                    let oUserData = await User.fetchById(this.id);

                    this.sUsername = oUserData.username;
                    this.sName = oUserData.name;
                    this.sPassword = oUserData.password;
                    this.sUserType = oUserData.user_type;
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }

            },
        },
        async beforeCreate() {
            try {
                this.oAuthUser = await User.getAuthUser();

                if (this.oAuthUser.user_type !== ADMIN_USER_TYPE) {
                    window.location.href = '/';
                }
            } catch (e) {
                alert(SYSTEM_ERROR_MESSAGE);
            }
        },
        beforeMount() {
            if (this.is_create === false) {
                this.setUserData();
            }
        }
    }

</script>
<style scoped></style>
