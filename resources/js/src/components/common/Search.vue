<template>
    <div class="d-flex justify-content-center">
        <div class="w-75  shadow p-3 rounded rounded-3">
            <form action="#" v-on:submit.prevent="emitSearch">
                <h3>Search and Sort</h3>
                <div class="row">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="input-group mb-3" style="width: 45%;">
                                <span class="input-group-text">Search By</span>
                                <select class="form-select" id="searchFieldOptions"
                                        v-model="sSearchField">
                                    <option disabled value="">Select Field</option>
                                    <option :value="sSearchFieldOriginal"
                                            v-for="(sSearchFieldAlias, sSearchFieldOriginal) in this.search_field_options">
                                        {{sSearchFieldAlias}}
                                    </option>
                                </select>
                            </div>
                            <div class="input-group mb-3" style="width: 45%;">
                                <input type="text" class="form-control" placeholder="Search"
                                       aria-label="Search"
                                       v-model="sSearchValue"
                                       aria-describedby="basic-addon2">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="input-group mb-3" style="width: 45%;">
                                <span class="input-group-text">Order By</span>
                                <select class="form-select" id="orderByOptions"
                                        v-model="sOrderByValue">
                                    <option disabled value="">Select Order</option>
                                    <option :value="sOrderByField"
                                            v-for="(sOrderByAlias, sOrderByField) in this.order_by_options">
                                        {{sOrderByAlias}}
                                    </option>
                                </select>
                            </div>

                            <div class="input-group mb-3" style="width: 45%;">
                                <span class="input-group-text">Sort By</span>
                                <select class="form-select" id="sortByOptions"
                                        v-model="sSortByValue">
                                    <option disabled value="">Select Sort Field</option>
                                    <option :value="sSortByField"
                                            v-for="(sSortByAlias, sSortByField) in this.oSortByOptions">
                                        {{sSortByAlias}}
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="row" v-if="is_blog_home">
                        <div class="row">
                            <div class="col-2">
                                <div class="row mb-2">
                                    <strong>Categories: </strong>
                                </div>
                                <div class="row px-2 mb-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                            v-on:click="checkAllCategory">Check All
                                    </button>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="form-check col-3"
                                         v-for="(oCategory, mKey) in categories">
                                        <input class="form-check-input" type="checkbox"
                                               :id="'cb_' + oCategory.title" :value="oCategory.id"
                                               v-model="oCategoriesCheckedValue[oCategory.id]"
                                        >
                                        <label class="form-check-label" :for="'cb_' + oCategory.title">{{_.upperFirst(oCategory.title)}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn fs-5 btn-success w-25"><strong>Go</strong></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>
<script>
    export default {
        name: "Search",
        props: [
            'search_field_options',
            'order_by_options',
            'is_blog_home',
            'default_search_field',
            'default_order_value',
            'default_sort_value',
            'categories'
        ],
        data() {
            return {
                oSortByOptions: {
                    'asc': 'Ascending',
                    'desc': 'Descending'
                },
                sSearchField: this.default_search_field ?? '',
                sSearchValue: '',
                sSortByValue: this.default_sort_value ?? 'desc',
                sOrderByValue: this.default_order_value ?? 'created_at',
                oCategories: this.categories,
                oCategoriesCheckedValue: {
                    1: true,
                    2: true,
                    3: true,
                    4: true,
                    5: true,
                    6: true,
                    7: true,
                    8: true,
                    9: true,
                    10: true,
                }
            };
        },
        methods: {
            emitSearch() {
                let sL5SearchString = this.setSearchFieldParam();

                if (this.is_blog_home === true) {
                    sL5SearchString += sL5SearchString.length === 0 ? '' : ';';
                    sL5SearchString += this.setCategorySearchParam();
                }

                let oSortAndOrderParam = this.setSortAndOrderParam();

                let oSearchValues = {
                    search: sL5SearchString, ...oSortAndOrderParam
                };

                this.$emit('input', oSearchValues);
            },
            checkAllCategory() {
                for (const [mKey, oCategory] of Object.entries(this.categories)) {
                    this.oCategoriesCheckedValue[oCategory.id] = true;
                }
            },
            setSearchFieldParam() {
                if (this.sSearchField.length === 0 || this.sSearchValue.length === 0) {
                    return '';
                }
                return this.sSearchField + ':' + this.sSearchValue;
            },
            setSortAndOrderParam() {
                return {sortedBy: this.sSortByValue, orderBy: this.sOrderByValue};
            },
            setCategorySearchParam() {
                let sCategoryIdSearch = '';

                for (const [sCategoryId, bChecked] of Object.entries(this.oCategoriesCheckedValue)) {
                    if (bChecked) {
                        sCategoryIdSearch += sCategoryId + ',';
                    }
                }

                sCategoryIdSearch = sCategoryIdSearch.length === 0 ? 0 : sCategoryIdSearch.slice(0, -1);

                return 'category_id:' + sCategoryIdSearch;
            },
        }
    };

</script>

<style scoped></style>
