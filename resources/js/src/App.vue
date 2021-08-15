<template>
    <div id="app">
        <div>
            <router-view />
        </div>
    </div>
</template>

<script>
    import JQuery from "jquery";
    // import "../../assets/css/fonts.css";
    // import "../../assets/css/global.css";
    window.$ = JQuery;

    export default {
        components: { },
        name: "App",
        methods: {},
    };
</script>

<style>
</style>
