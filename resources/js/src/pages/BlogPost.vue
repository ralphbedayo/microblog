<template>
    <div>
        <navbar></navbar>
        <div class="container pb-5" style="padding-top: 100px">
            <div class="row navigation-section">
                <div class="d-flex justify-content-end">
                    <router-link class="btn btn-outline-primary" to="/"> Back</router-link>
                </div>
            </div>
            <div class="row mt-5 blog-section">
                <div class="row mb-3">
                    <h1> {{ this.oBlogItem.title}} </h1>
                    <span class="fst-italic">{{ this.oBlogItem.author_name}}</span> <br>
                    <span class="small text-secondary">Created: {{ moment(this.oBlogItem.created_at).format(sDateTimeFormat)}}</span>
                    <br>
                    <span class="small text-secondary">Last Updated: {{ moment(this.oBlogItem.updated_at).format(sDateTimeFormat)}}</span>
                    <br>
                </div>
                <div class="row">
                    <p> {{ this.oBlogItem.content}}</p>
                </div>
            </div>
            <div class="row mt-5 border-top border-1 border-secondary comment-section">
                <div class="col-8 mt-3">
                    <div class="row">
                        <h3 class="px-0">Comments</h3>
                    </div>

                    <div class="row mt-3 ">
                        <div class="row">
                            <div class="shadow p-2 rounded rounded-3">
                                <form action="" v-on:submit.prevent="addComment">
                                    <div class="input-group">
                                        <input v-model="sCommentContent" type="text" class="form-control"
                                               placeholder="Write a comment" minlength="5" maxlength="100"
                                               aria-label="Write a comment" aria-describedby="add-comment-button">
                                        <button type="submit" class="btn btn-success" id="add-comment-button">
                                            Add
                                        </button>
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
                                            <div class="input-group me-2">
                                                <input v-model="sEditCommentContent" type="text" class="form-control"
                                                       placeholder="Write comment replacement" minlength="5"
                                                       maxlength="100"
                                                       aria-label="Write comment replacement"
                                                       aria-describedby="edit-comment-button">
                                                <button type="submit" class="btn btn-outline-success "
                                                        id="edit-comment-button">
                                                    Submit
                                                </button>
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

    import User from "../models/User";
    import {ADMIN_USER_TYPE, DATE_TIME_FORMAT, DELETE_RESOURCE_CONFIRM_MESSAGE} from "../constants/common";
    import Navbar from "../components/navbar/Navbar";
    import Blog from "../models/Blog";
    import Comment from "../models/Comment";

    export default {
        name: "BlogPost",
        components: {Navbar},
        data() {
            return {
                iBlogId: this.$route.params.id,
                oBlogItem: {},
                oAuthUser: {},
                sDateTimeFormat: DATE_TIME_FORMAT,
                sCommentContent: '',
                oEditState: {},
                sEditCommentContent: ''
            }
        },
        methods: {
            async addComment() {
                let oData = {
                    blog_id: this.iBlogId,
                    comment_author_id: this.oAuthUser.id,
                    content: this.sCommentContent
                };

                let iResponseCode = await Comment.createComment(oData);

                if (iResponseCode === 200) {
                    this.oBlogItem = await Blog.fetchById(this.iBlogId);
                    this.sCommentContent = '';
                }
            },
            async deleteComment(iId) {
                if (confirm(DELETE_RESOURCE_CONFIRM_MESSAGE) === false) {
                    return;
                }

                let iResponseCode = await Comment.deleteComment(iId);

                if (iResponseCode === 200) {
                    this.oBlogItem = await Blog.fetchById(this.iBlogId);
                    this.sCommentContent = '';
                }
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

                let iResponseCode = await Comment.updateComment(iId, {content: this.sEditCommentContent});

                if (iResponseCode === 200) {
                    this.cancelEdit();
                    this.oBlogItem = await Blog.fetchById(this.iBlogId);
                }
            }
        },
        async beforeCreate() {
            this.oAuthUser = await User.getAuthUser();

            if (this.oAuthUser.user_type === ADMIN_USER_TYPE) {
                window.location.href = '/admin';
            }
        },
        async beforeMount() {
            this.oBlogItem = await Blog.fetchById(this.iBlogId);
        }
    }
</script>

<style scoped></style>
