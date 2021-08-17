<template>
    <div>
        <nav class="navbar navbar-dark bg-primary">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    <span class="text-lg text-white fw-bold me-auto">
                        Blog Spotter
                    </span>
                </router-link>
                <span class="text-white ms-auto me-5"> Hi, <strong> {{ this.auth_user.name}}</strong>  </span>
                <a href="/logout" class="btn btn-outline-light">
                    Logout
                </a>
            </div>
        </nav>
    </div>
</template>
<script>
    export default {
        name: "Navbar",
        props: ['auth_user'],
        methods: {}
    };

</script>

<style scoped></style>
