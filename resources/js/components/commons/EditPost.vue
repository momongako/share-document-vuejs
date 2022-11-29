<template>
    <div class="box-edit-post">
        <form class="form-update-post" enctype="multipart/form-data" @submit.prevent="save">
            <div id ="new-post-style">
                <div class ="col-sm-10 col-lg-10" id="title">Edit Post</div>
                <div class="col-sm-2 col-lg-2" id = "button-submit-top">
                    <router-link :to="{name: 'detailPost', params: {id: this.$route.params.id}}" class="btn btn-light">
                        Cancel
                    </router-link>
                    <button type="submit" id="button-submit" class="btn btn-success">Submit</button>
                </div>
            </div>
            <!--title-->
            <div class="form-group row">
                <label class="col-form-label col-sm-2">Title
                    <span class="required">*</span>
                </label>
                <div class="col-sm-10">
                    <input class="form-control col-sm-12 input-color size-input" style="width: 100%" name="title" placeholder="Please enter the post title"
                           v-model="infoPostCategory.title"
                           v-validate="'required|max:255'"
                           @change="changeInput('title')"
                    />
                    <div v-show="errors.has('title')" class="input-group text-danger" role="alert">
                        {{ errors.first('title') }}
                    </div>

                    <div
                        v-if="sysError.title"
                        class="input-group text-danger"
                        role="alert"
                    >
                        {{ sysError.title[0] }}
                    </div>
                </div>

            </div>
            <!--category-->
            <div class="form-group row">
                <label class="input-title col-sm-2">Category
                    <span class="required">*</span>
                </label>
                <div class="col-sm-10">
                    <select v-model="infoPostCategory.category_id" name="category_id"
                            class="custom-select my-1 mr-sm-2 category-select col-sm-10 input-color size-input"
                            v-validate="'required'"
                            @change="changeInput('category_id')"
                    >
                        <option style="background-color: white" value="">-- Select category --</option>
                        <option style="background-color: white"
                                v-for="category in categories" v-bind:title="category.name"
                                v-bind:value="category.id">
                            <p v-if="category.name.length > 50">{{ category.name.substring(0,50)+'...' }}</p>
                            <p v-else> {{ category.name }}</p>
                        </option>
<!--                        <option v-else style="background-color: white"-->
<!--                                v-for="category in categories" v-bind:title="category.name"-->
<!--                                v-bind:value="category.id">-->
<!--                            {{ category.name }}-->
<!--                        </option>-->
                    </select>
                    <div v-show="errors.has('category_id')" class="input-group text-danger" role="alert">
                        {{ errors.first('category_id') }}
                    </div>

                    <div
                        v-if="sysError.category_id"
                        class="input-group text-danger"
                        role="alert"
                    >
                        {{ sysError.category_id[0] }}
                    </div>
                </div>

            </div>
            <!--Attachments -->
            <div class="form-group row">
                <label class="input-title col-sm-2">Attachments
                    <span class="required">*</span>
                </label>

                <div class="col-sm-10">
                    <table class="tbl-attachment"
                           :class="addClassDocAttach">
                        <tr>
                            <th style="width: 60%">File name</th>
                            <th>Size</th>
                            <th>Remove</th>
                        </tr>
                        <tr :class="showAttach" v-for="(item, index) in listDocAttach" :key="index">
                            <td>{{ item.name }}</td>

                            <td v-if="item.size/1024/1024 < 1 ">
                                {{ (item.size /1024).toFixed(2) }} KB
                            </td>

                            <td v-if="item.size/1024/1024 >= 1 ">
                                {{ (item.size /1024/1024).toFixed(2) }} MB
                            </td>

                            <td><a class="">
                                <img @click="removeFileAttach($event,index, item.id)" class="img-logo" src="assets/logo/sign-delete-icon.png">
                            </a></td>
                        </tr>
                        <tr style="border-top: 1px solid #dddddd;">
                            <td>
                                <button type="button" id="add-file" class="btn btn-default add-attachment"
                                        @click="$refs.attachment.click()">
                                    Add file
                                </button>
                            </td>
                            <td style="color:red">*Maximum 50MB</td>
                        </tr>
                    </table>
                    <input name="filesAttach" multiple type="file" ref="attachment" class="d-none input-color"
                           @change="onDocChanged"
                    />

                    <div
                        v-if="checkFileUpload"
                        class="input-group text-danger"
                        role="alert"
                    >
                        {{ errMessageEncrypt }}
                    </div>

                    <div
                        v-if="checkFileUpload"
                        class="input-group text-danger"
                        role="alert"
                    >
                        {{ errMessageEncrypt }}
                    </div>
                    <div
                        class="text-danger input-group"
                        role="alert"
                        v-if="messErrorFile"
                    >
                        {{ messErrorFile }}
                    </div>
                </div>


            </div>
            <!--end Attachments-->

            <!--content-->
            <div class="form-group row form-input-content">
                <label class="input-title col-sm-2">Content
                    <span class="required">*</span>
                </label>
                <div class="col-sm-10">
                    <vue-editor
                        name="content"
                        id="editor"
                        useCustomImageHandler
                        @image-added="handleImageAdded"
                        v-model="infoPostCategory.content"
                        v-validate="'required'"
                        class="input-color"
                    >
                    </vue-editor>

                    <div v-show="errors.has('content')" class="input-group text-danger" role="alert">
                        {{ errors.first('content') }}
                    </div>
                    <div
                        v-if="sysError.content"
                        class="input-group text-danger"
                        role="alert"
                    >
                        {{ sysError.content[0] }}
                    </div>
                </div>
            </div>
            <!--end content-->

            <!--Referrence-->
            <div class="form-group row post-referrence">
                <label class=" col-sm-2 lbl-post input-title">
                    Reference
                </label>

                <div class="col-sm-10" style="margin-left: 0px">
                    <input type="text" class="form-control in-post-referrence size-input input-color" v-model="searchText" @keyup="searchByTitle()" placeholder="Search for post title">

                    <div style="max-height: 300px;overflow-y: auto" class ="border-list-referrence">
                        <ul class="list-search-referrence" v-for="searchArr in searchArrs">
                            <li v-bind:title="searchArr.title" class="text-truncate" @click="addToListReferrence(searchArr)">{{ searchArr.title }}</li>
                        </ul>
                    </div>

                    <ul class="list-referrence-selected" v-if="listReferrence.length > 0" v-for="(item, index) in listReferrence">
                        <li>
                            <span v-bind:title="item.title"  class="text-truncate col-lg-10">
                                {{ item.title }}
                            </span>
                            <i class="bi bi-x-lg" style="float: right;color:red" @click="removeReferrence($event,index, item.id)"></i>
                        </li>
                    </ul>
                </div>

            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios"
import EventBus from "../../EventBus";
import * as Const from "../../const";
import BaseDialog from "./BaseDialog"
import {IS_ADMIN} from "../../const";

export default {
    components: {Const, BaseDialog},
    created() {
    },
    data() {
        return {
            listDocAttach: [],
            classDocAttach: '',
            showAttach: 'd-none',
            infoPostCategory: {
                title: '',
                category_id:'',
                category_name:'',
                content: '',
                filesAttach: [],
                referrence :[]
            },
            sysError: {},
            mess: '',
            isShowMessageFile: false,
            messErrorFile: "",
            removeFile: Const.NOT_REMOVE_IMAGE,
            listFileRemove: [],
            isAdmin: '',
            checkFileUpload: false,
            errMessageEncrypt: '',
            categories: [],
            msgAdded:'',
            listReferrence:[],
            searchText: '',
            searchArrs: [],
            userInfo: [],
            userId: 0,
            userCompany:'',
            hasAccess:false,
            IS_ADMIN: IS_ADMIN
        }
    },

    mounted()  {
        // show
        axios.get('/get-detail-post/' + this.$route.params.id +"/editPost")
            .then(response =>{
                  if(response.data.hasAccess === false){
                    this.$router.push('/');
                  }
                this.infoPostCategory = response.data.post;
                this.listDocAttach = response.data.listAttachment;
                this.infoPostCategory.filesAttach = response.data.listAttachmentAdded;

                this.listReferrence = response.data.listPostAddReferrence;
                this.infoPostCategory.referrence = response.data.arrayIdReferrence;
            }).catch(error =>{
            console.log(error);
        });
        this.getUserInfo();
        this.getCategories();

    },

    methods: {

        getUserInfo()
        {
            let that = this;
            axios.get('/get-user-info').then(response=>{
                that.userInfo = response.data.infoUser;
                that.isAdmin = that.userInfo.is_admin;
                that.userId = that.userInfo.id;
                that.userCompany = that.userInfo.user_company;
            })
        },

        removeReferrence(e, index, itemId){
            this.listReferrence.splice(index, 1);
            this.infoPostCategory.referrence.splice(index, 1);
        },

        addToListReferrence(item){
            this.infoPostCategory.referrence.unshift(item.id);
            this.listReferrence.unshift(item);
        },

        searchByTitle()
        {

            axios.post('/search-by-title',{
                title: this.searchText,
                postId : this.$route.params.id
            })
                .then(result => {
                    this.searchArrs = result.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },

        getCategories()
        {
            var that = this;
            axios.get('/category').then(response=>{
                that.categories = response.data
            })
        },

        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
            var formData = new FormData();
            formData.append("image", file);

            axios.post('/upload-image-ckeditor', formData)
                .then(result => {
                    if (result.data.result) {
                        const url = result.data.path; // Get url from response
                        Editor.insertEmbed(cursorLocation, "image", url);
                        resetUploader();
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        handleOk() {
            location.reload();
        },
        onDocChanged(e) {
            let files = e.target.files;
            this.checkDocUpload(files);
        },
        save() {
            var that = this;
            this.$validator
                .validateAll()
                .then((valid) => {
                    if (this.listDocAttach.length == 0) {
                        that.isShowMessageFile = true;
                        that.messErrorFile = 'The attachment field is required'
                    }
                    if (this.listDocAttach.length > 0) {
                        that.isShowMessageFile = false;
                    }

                    if (valid && !that.isShowMessageFile) {
                      this.$isLoading(true);
                        that.submit();
                    }
                })
                .catch(function (e) {
                    console.log(e)
                });
        },
        submit(e) {
            let formdata  = new FormData();
            var that = this;
            let dataPostCategory = this.infoPostCategory;
            formdata.append("_method", "PUT");
            formdata.append("listFileRemove", this.listFileRemove);
            for (let key in dataPostCategory) {
                if (key === "filesAttach"
                ) {
                    dataPostCategory[key].forEach(item =>
                        formdata.append(key + "[]", item)
                    );
                } else {
                    formdata.append(key, dataPostCategory[key]);
                }
            }

            axios.post('/edit-post', formdata)
                .then((response) => {
                    if (response.data.result) {
                      this.$isLoading(false);
                           that.$router.push('/post/detail/' + this.$route.params.id);

                          that.msgAdded = 'Post Updated Successfully';

                          that.$toast.success(that.msgAdded, {
                            position: "top-right",
                            timeout: 3000,
                            closeOnClick: true,
                            pauseOnFocusLoss: true,
                            pauseOnHover: true,
                            draggable: true,
                            draggablePercent: 0.6,
                            showCloseButtonOnHover: false,
                            hideProgressBar: true,
                            closeButton: "button",
                            icon: true,
                            rtl: false
                          });
                    }
                })
                .catch((err) => {
                    if (err.response.status === 403) {
                        this.$toast.error("You do not have access!", {
                            position: "top-right",
                            timeout: 5000,
                            closeOnClick: true,
                            pauseOnFocusLoss: true,
                            pauseOnHover: true,
                            draggable: true,
                            draggablePercent: 0.6,
                            showCloseButtonOnHover: false,
                            hideProgressBar: true,
                            closeButton: "button",
                            icon: true,
                            rtl: false
                        });
                    } else if (err.response.data.errorPin) {
                        that.$refs.openModal.click();
                    } else if (err.response.data.message) {
                        that.mess = err.response.data.message;
                    } else {
                        for (const [key, value] of Object.entries(err.response.data)) {
                            that.errMessageEncrypt = value[0]
                        }
                        that.checkFileUpload = true;
                    }
                });
        },
        changeInput(fieldName) {
            this.sysError = {};
            this.mess = null;
        },
        removeFileAttach(e, index, fileId) {
            this.listDocAttach.splice(index, 1);
            this.infoPostCategory.filesAttach.splice(index, 1);
            this.removeFile = Const.REMOVE_IMAGE;
            this.listFileRemove.push(fileId);
            if (this.listDocAttach.length == 0) {
                this.$refs.attachment.value = null;
                this.errMessageEncrypt = ''
            }
        },
        returnListPost(e) {
            location.reload();
        },
        checkDocUpload(files) {

            var totalFileSize = 0;
            for (let file of files) {
                totalFileSize += file.size;
                let reader = new FileReader();
                reader.readAsDataURL(file);
                this.infoPostCategory.filesAttach.unshift(file);
                this.listDocAttach.unshift(file);
                this.isShowMessageFile = false;
                this.messErrorFile = "";
                this.sysError = {};
            }

            if ((totalFileSize / (1024 * 1024)) > Const.MAX_UPLOAD_ATTACHMENT) {
                this.infoPostCategory.filesAttach = [];
                this.listDocAttach = [];
                this.isShowMessageFile = true
                this.messErrorFile = 'Maximum files size allowed is 50 MB'
            }
        }
    },
    computed: {
        addClassDocAttach() {
            if (this.listDocAttach.length === 0) {
                return ''
            } else {
                this.showAttach = ''
                return 'doc-attached'
            }
        }
    },
    watch: {

    }
}
</script>
<style>
/*input*/
    .size-input {
        height: 50px;
        border-radius: 6px;
        border: none;
        background-color: #F3F3F3;
    }
    .input-color {
        background-color: #F3F3F3;
    }
    .category-select {
        width: 43%;
        height: 50px;
        font-size: 14px;
        display: block;
    }
/*input*/
</style>
