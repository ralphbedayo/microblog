<template>
    <div>
        <button class="btn btn-outline-primary" v-on:click="prevPage" :disabled="this.iPage === 1">
            <
        </button>
        <span class="mx-1">Page {{ this.current_page}} out of {{ total_page}}</span>
        <button class="btn btn-outline-primary" v-on:click="nextPage"
                :disabled="this.current_page === this.total_page"> >
        </button>
    </div>
</template>
<script>
    export default {
        name: "Pagination",
        props: ['total_page', 'current_page'],
        data() {
            return {
                iPage: this.current_page ?? 1
            };
        },
        watch: {
            total_page(newVal) {
                if (newVal < this.current_page) {
                    this.iPage = newVal;
                    this.emitSearch();
                }
            }
        },
        methods: {
            emitSearch() {
                this.$emit('input', this.iPage);
            },
            prevPage() {
                this.iPage -= 1;
                this.emitSearch();
            },
            nextPage() {
                this.iPage += 1;
                this.emitSearch();
            }
        },

    }

</script>
<style scoped></style>
