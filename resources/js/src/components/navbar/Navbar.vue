<template>
    <div>
        <nav class="navbar navbar-dark bg-primary">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    <span class="text-lg text-white fw-bold me-auto">
                        Blog Spotter
                    </span>
                </router-link>
                <a href="/logout" class="btn btn-outline-light ms-auto">
                    Logout
                </a>
            </div>
        </nav>
    </div>
</template>
<script>
    export default {
        name: "Navbar",
        methods: {
        }
    };

</script>

<style scoped></style>
