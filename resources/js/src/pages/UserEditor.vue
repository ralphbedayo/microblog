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
                        <form action="" v-on:submit.prevent="saveUser" novalidate>
                            <div class="row">

                                <div class="input-group has-validation mb-3">
                                    <span class="input-group-text" id="name-label"> Name </span>
                                    <input type="text"  placeholder="Enter full name"
                                           aria-label="Enter full name" aria-describedby="name-label"
                                           minlength="5" maxlength="150"
                                           required
                                           :class="{'form-control': true, 'is-invalid': ($v.sName.$error)}"
                                           v-model.trim="$v.sName.$model"
                                    >
                                    <div class="invalid-feedback" v-if="!$v.sName.required"> Name is required.</div>
                                    <div class="invalid-feedback" v-if="!$v.sName.minLength"> Name must have at least {{$v.sName.$params.minLength.min}} letters.</div>
                                    <div class="invalid-feedback" v-if="!$v.sName.maxLength"> Name have a limit of {{$v.sName.$params.maxLength.max}} letters.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group has-validation mb-3">
                                    <span class="input-group-text" id="username-label"> Username </span>
                                    <input type="text" class="form-control" placeholder="Enter an alphanumeric username"
                                           aria-label="Enter an alphanumeric username" aria-describedby="username-label"
                                           minlength="5" maxlength="50"
                                           required pattern="[a-zA-Z0-9]+"
                                           :disabled="is_create === false"
                                           :class="{'form-control': true, 'is-invalid': ($v.sUsername.$invalid && $v.sUsername.$dirty) || bUsernameExists}"
                                           v-model.trim="$v.sUsername.$model"
                                    >
                                    <div class="invalid-feedback" v-if="bUsernameExists"> Username already exists.</div>
                                    <div class="invalid-feedback" v-if="!$v.sUsername.required"> Username is required.</div>
                                    <div class="invalid-feedback" v-if="!$v.sUsername.alphaNum"> Username should be alpha-numeric.</div>
                                    <div class="invalid-feedback" v-if="!$v.sUsername.minLength"> Username must have at least {{$v.sUsername.$params.minLength.min}} letters.</div>
                                    <div class="invalid-feedback" v-if="!$v.sUsername.maxLength"> Username have a limit of {{$v.sUsername.$params.maxLength.max}} letters.</div>
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
                                           :class="{'form-control': true, 'is-invalid': ($v.sPassword.$invalid && $v.sPassword.$dirty)}"
                                           v-model.trim="$v.sPassword.$model"
                                    >
                                    <div class="invalid-feedback" v-if="!$v.sPassword.required"> Password is required.</div>
                                    <div class="invalid-feedback" v-if="!$v.sPassword.alphaNum"> Password should be alpha-numeric.</div>
                                    <div class="invalid-feedback" v-if="!$v.sPassword.minLength"> Password must have at least {{$v.sPassword.$params.minLength.min}} letters.</div>
                                    <div class="invalid-feedback" v-if="!$v.sPassword.maxLength"> Password have a limit of {{$v.sPassword.$params.maxLength.max}} letters.</div>
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
    import {required, minLength, maxLength, alphaNum, } from 'vuelidate/lib/validators';
    import {AuthUserMixin} from "../mixins/AuthUserMixin";

    export default {
        name: 'UserEditor',
        components: {Navbar},
        props: ['is_create', 'id'],
        mixins: [AuthUserMixin],
        data() {

            return {
                sUsername: '',
                sName: '',
                sPassword: '',
                sUserType: BLOGGER_USER_TYPE,
                aUserTypes: [ADMIN_USER_TYPE, BLOGGER_USER_TYPE],
                oValidationMessages: {},
                bUsernameExists: false
            };
        },
        validations: {
            sName: {
                required,
                minLength: minLength(5),
                maxLength: maxLength(100),
            },
            sUsername: {
                required,
                alphaNum,
                minLength: minLength(5),
                maxLength: maxLength(50),
            },
            sPassword: {
                required,
                alphaNum,
                minLength: minLength(5),
                maxLength: maxLength(50),
            },
            sUserType: {
                required,
                alphaNum
            },

        },
        methods: {
            async saveUser() {
                this.bUsernameExists = await this.checkUsernameExists();

                this.$v.$touch();
                if (this.$v.$invalid || this.bUsernameExists) {
                    return;
                }

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
            async checkUsernameExists() {
                let oSearchParams = {
                    search: 'username:' + this.sUsername,
                    searchFields: 'username:='
                };

                try {
                    let oResponse = await User.fetchAll(oSearchParams);

                    return oResponse.data.length > 0;
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }
            }
        },
        async beforeMount() {
            this.oAuthUser = await this.getAuthUser(true);

            if (this.is_create === false) {
                this.setUserData();
            }
        }
    }

</script>
<style scoped></style>
