<template>
    <div>
        <navbar></navbar>
        <div class="container"></div>

    </div>
</template>
<script>
    import store from "../store";
    import User from "../models/User";
    import {ADMIN_USER_TYPE} from "../constants/common";
    import Navbar from "../components/navbar/Navbar";

    export default {
        name: "Admin",
        components: {Navbar},
        data() {

        },
        methods: {},
        async beforeCreate() {
            if (store.state.authenticated === false) {
                let oAuthUser = await User.getAuthUser();

                if (oAuthUser.user_type !== ADMIN_USER_TYPE) {
                    window.location.href = '/';
                }
            }
        },
        beforeMount() {
        }
    }
</script>

<style scoped></style>
