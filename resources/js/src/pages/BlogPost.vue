<template>
    <div>
        <navbar :auth_user="this.oAuthUser"></navbar>
        <div class="container pb-5" style="padding-top: 100px">
            <div class="row navigation-section">
                <div class="d-flex justify-content-end">
                    <router-link class="btn btn-primary" to="/"> Back</router-link>
                </div>
            </div>
            <div class="row mt-5 blog-section">
                <div class="row mb-3">
                    <h1> {{ this.oBlogItem.title}} </h1>
                    <p class="fst-italic">{{ this.oBlogItem.author_name}}</p>
                    <span class="small text-secondary">Category: {{ _.upperFirst(this.oBlogItem.category)}}</span> <br>
                    <span class="small text-secondary">Created: {{ moment(this.oBlogItem.created_at).format(sDateTimeFormat)}}</span>
                    <br>
                    <span class="small text-secondary">Last Updated: {{ moment(this.oBlogItem.updated_at).format(sDateTimeFormat)}}</span>
                    <br>
                </div>
                <div class="row">
                    <p> {{ this.oBlogItem.content}}</p>
                </div>

                <div class="row mt-2 ">
                    <div class="d-flex justify-content-end">
                        <div v-if="oAuthUser.id === this.oBlogItem.author_id">
                            <router-link class="btn btn-sm btn-outline-primary"
                                         :to="'/blog/' + this.oBlogItem.id + '/edit'"> Edit
                            </router-link>
                            <button class="btn btn-sm btn-danger mx-1"
                                    v-on:click="deleteBlog()"> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3 border-top border-1 border-secondary comment-section">
                <div class="col-8 mt-3">
                    <div class="row">
                        <h3 class="px-0">Comments</h3>
                    </div>

                    <div class="row mt-3 ">
                        <div class="row">
                            <div class="shadow p-2 rounded rounded-3">
                                <form action="" v-on:submit.prevent="addComment" novalidate>
                                    <div class="input-group has-validation">
                                        <input type="text" class="form-control"
                                               placeholder="Write a comment" minlength="5" maxlength="255"
                                               aria-label="Write a comment" aria-describedby="add-comment-button"
                                               :class="{'form-control': true, 'is-invalid': $v.sCommentContent.$error}"
                                               v-model.trim="$v.sCommentContent.$model"
                                        >
                                        <button type="submit" class="btn btn-success" id="add-comment-button" :disabled="this.sCommentContent.length === 0">
                                            Add
                                        </button>
                                        <div class="invalid-feedback" v-if="!$v.sCommentContent.minLength"> Comment must have at least {{$v.sCommentContent.$params.minLength.min}} letters.</div>
                                        <div class="invalid-feedback" v-if="!$v.sCommentContent.maxLength"> Comment have a limit of {{$v.sCommentContent.$params.maxLength.max}} letters.</div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 comment-list">
                        <div class="row mb-3" v-for="(oCommentItem, mKey) in oBlogItem.comments">
                            <div class="shadow p-2 rounded rounded-3">
                                <div class="d-flex justify-content-between">
                                    <h6>{{oCommentItem.comment_author.id === oAuthUser.id ? 'You' :
                                        oCommentItem.comment_author.name }}</h6>

                                    <div v-if="oAuthUser.id === oCommentItem.comment_author.id">
                                        <button class="btn btn-sm btn-outline-primary mx-1"
                                                v-on:click="startEdit(oCommentItem.id, oCommentItem.content) "> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger mx-1"
                                                v-on:click="deleteComment(oCommentItem.id)"> Delete
                                        </button>
                                    </div>
                                </div>

                                <p> {{oCommentItem.content}}</p>

                                <div class="mt-2"
                                     v-if="oEditState.hasOwnProperty(oCommentItem.id)">
                                    <form action="" v-on:submit.prevent="editComment(oCommentItem.id)">
                                        <div class="d-flex">
                                            <div class="input-group me-2 has-validation">
                                                <input type="text" class="form-control"
                                                       placeholder="Write comment replacement" minlength="5"
                                                       maxlength="255"
                                                       aria-label="Write comment replacement"
                                                       aria-describedby="edit-comment-button"
                                                       :class="{'form-control': true, 'is-invalid': $v.sEditCommentContent.$error}"
                                                       v-model.trim="$v.sEditCommentContent.$model"
                                                >

                                                <button type="submit" class="btn btn-outline-success "
                                                        id="edit-comment-button" :disabled="sEditCommentContent.length === 0">
                                                    Submit
                                                </button>
                                                <div class="invalid-feedback" v-if="!$v.sEditCommentContent.required"> Updated Comment is required.</div>
                                                <div class="invalid-feedback" v-if="!$v.sEditCommentContent.minLength"> Comment must have at least {{$v.sEditCommentContent.$params.minLength.min}} letters.</div>
                                                <div class="invalid-feedback" v-if="!$v.sEditCommentContent.maxLength"> Comment have a limit of {{$v.sEditCommentContent.$params.maxLength.max}} letters.</div>
                                            </div>
                                            <button type="button" class="btn btn-secondary" v-on:click="cancelEdit">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import {
        DATE_TIME_FORMAT,
        DELETE_RESOURCE_CONFIRM_MESSAGE,
        OK_STATUS,
        SYSTEM_ERROR_MESSAGE
    } from "../constants/common";
    import Navbar from "../components/navbar/Navbar";
    import Blog from "../models/Blog";
    import Comment from "../models/Comment";
    import {maxLength, minLength, required} from "vuelidate/lib/validators";
    import {AuthUserMixin} from "../mixins/AuthUserMixin";

    export default {
        name: "BlogPost",
        components: {Navbar},
        mixins: [AuthUserMixin],
        data() {
            return {
                iBlogId: this.$route.params.id,
                oBlogItem: {},
                sDateTimeFormat: DATE_TIME_FORMAT,
                sCommentContent: '',
                oEditState: {},
                sEditCommentContent: ''
            }
        },
        validations: {
            sCommentContent: {
                minLength: minLength(5),
                maxLength: maxLength(250),
            },
            sEditCommentContent: {
                required,
                minLength: minLength(5),
                maxLength: maxLength(250),
            }
        },
        methods: {
            async addComment() {
                this.$v.$touch();

                if (this.sCommentContent.length === 0 || this.$v.sCommentContent.$invalid) {
                    return;
                }

                let oData = {
                    blog_id: this.iBlogId,
                    comment_author_id: this.oAuthUser.id,
                    content: this.sCommentContent
                };

                this.$isLoading(true);
                try {
                    let iResponseCode = await Comment.createComment(oData);

                    if (iResponseCode === OK_STATUS) {
                        this.oBlogItem = await Blog.fetchById(this.iBlogId);
                        this.sCommentContent = '';
                    }
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }
                this.$isLoading(false);
            },
            async deleteComment(iId) {
                if (confirm(DELETE_RESOURCE_CONFIRM_MESSAGE) === false) {
                    return;
                }

                this.$isLoading(true);
                try {
                    let iResponseCode = await Comment.deleteComment(iId);

                    if (iResponseCode === OK_STATUS) {
                        this.oBlogItem = await Blog.fetchById(this.iBlogId);
                        this.sCommentContent = '';
                    }
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }
                this.$isLoading(false);
            },
            startEdit(iId, sContent) {
                this.sEditCommentContent = sContent;
                this.oEditState = {};
                this.oEditState[iId] = true;
            },
            cancelEdit() {
                this.sEditCommentContent = '';
                this.oEditState = {};
            },
            async editComment(iId) {
                this.$v.$touch();

                if (this.sEditCommentContent.length === 0 || this.$v.sEditCommentContent.$invalid) {
                    return;
                }

                this.$isLoading(true);
                try {
                    let iResponseCode = await Comment.updateComment(iId, {content: this.sEditCommentContent});

                    if (iResponseCode === OK_STATUS) {
                        this.cancelEdit();
                        this.oBlogItem = await Blog.fetchById(this.iBlogId);
                    }
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }
                this.$isLoading(false);
            },
            async deleteBlog() {
                if (confirm(DELETE_RESOURCE_CONFIRM_MESSAGE) === false) {
                    return;
                }


                this.$isLoading(true);
                try {
                    let iResponseCode = await Blog.deleteBlog(this.oBlogItem.id);

                    if (iResponseCode === OK_STATUS) {
                        await this.$router.push({path: '/'});
                    }
                } catch (e) {
                    alert(SYSTEM_ERROR_MESSAGE);
                }
                this.$isLoading(false);
            }
        },
        async beforeMount() {
            this.$isLoading(true);
            this.oAuthUser = await this.getAuthUser();
            try {
                this.oBlogItem = await Blog.fetchById(this.iBlogId);
            } catch (e) {
                alert(SYSTEM_ERROR_MESSAGE);
            }
            this.$isLoading(false);
        }
    }
</script>

<style scoped></style>
