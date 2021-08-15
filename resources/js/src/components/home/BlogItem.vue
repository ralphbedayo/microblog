<template>
    <div :class="this.class_string" style="width: 45%">
        <div class="row w-100 mb-4">
            <div class="w-100 shadow rounded rounded-3 px-0">
                <div class="p-3">
                    <span class="text-dark"> {{ this.blog.author.name}}</span>
                    <h2 class="mt-3">{{ this.blog.title}}</h2>
                </div>

                <div class="bg-primary text-white fw-bold p-3">
                    <span class="fst-italic"><small>Category: </small> {{ _.upperCase(this.blog.category ) }}</span>
                    <br>
                    <span
                        class="small">Created: {{ moment(this.blog.created_at).format(sDateTimeFormat) }}</span>
                    <br>
                    <span class="small">Last Updated: {{ moment(this.blog.updated_at).format(sDateTimeFormat) }}</span>
                    <br>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    import {DATE_TIME_FORMAT} from "../../constants/common";

    export default {
        name: "BlogItem",
        props: ['blog', 'class_string'],
        methods: {},
        data() {
            return {
                sDateTimeFormat : DATE_TIME_FORMAT
            };
        }
    };

</script>
<style scoped>

</style>
