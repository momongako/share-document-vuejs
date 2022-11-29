<template>
    <div class="post-detail">
            <div v-if="post.user_id === userId || isAdmin === IS_ADMIN" class="show-button-edit-delete">
                <div  class="list-button-delete-edit">
                    <a href="javascript:;" v-on:click="showDialogConfirm()" class="btn btn-default">Delete</a>

                    <router-link :to="{name: 'editPost', params: {id: this.$route.params.id}}"
                                 class="btn detail-btn-edit-post" id="button-submit">
                        Edit
                    </router-link>

                </div>

            </div>

            <div class="detail-post-h4" style="margin-left: 5px">
                <h4 class="detail-post" style="font-weight: 600">
                    <span>{{post.title}}</span>
                </h4>
            </div>

            <hr/>



            <div class="form-group mar-left-15" style="height: 25px;">
                <div class="post-detail-submitter">
                    <label class="post-label">Submitter
                    </label>
                    <input v-bind:title="post.user_name" class="form-control detail title-detail title-detail-user-name" type="text" :value="post.user_name"
                           aria-label="Disabled input example" readonly>
                </div>

                <div class="post-detail-created-at">
                    <label class="post-label">Created date
                    </label>
                    <input

                        class="form-control detail title-detail title-detail-create-at" type="text" :value="post.created_at | formatOnlyDate"
                           aria-label="Disabled input example"  readonly>
                </div>
            </div>

            <div class="form-group mar-left-15 d-flex">
                <label class="post-label">Category
                </label>
                <input v-bind:title="post.category_name" class="form-control detail title-detail title-detail-category" type="text" :value="post.category_name"
                       aria-label="Disabled input example"  readonly>
            </div>

            <div class="form-group mar-left-15 d-flex">
                <label class="input-title" style="margin-left: 10px;width: 140px;margin-top: 40px">
                    Attachments
                </label>
                <div class="col-sm-11">
                    <span :class="[{disablelClickDownload: listAttachment.length < 2}]"
                          class="download-all-attachment">
                        <a  :href="'/zip-and-download/' + this.$route.params.id" class="btn">
                            Download All
                        </a>
                    </span>

                    <table class="tbl-attachment-detail">
                        <tr>
                            <th style="width: 60%">File name</th>
                            <th>Size</th>
                            <th style="text-align: center">Download</th>
                        </tr>
                        <tr v-for="(attachment, index) in listAttachment">
                            <td>
                                {{attachment.name}}
                            </td>

                            <td v-if="attachment.size/1024/1024 < 1 ">
                                {{ (attachment.size /1024).toFixed(2) }} KB
                            </td>

                            <td v-if="attachment.size/1024/1024 >= 1 ">
                                {{ (attachment.size /1024/1024).toFixed(2) }} MB
                            </td>

                            <td style="text-align: center" @click="download(attachment.path, attachment.name)">
                                <i class="bi bi bi-download fa-2xl"></i>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <div class="form-group form-input-content mar-left-15 d-flex">
                <label class="input-title" style="width: 140px;margin-left: 10px">
                    Content
                </label>
                <div class="post-content" v-html="post.content"></div>
            </div>

            <div class="form-group post-referrence mar-left-15 d-flex" style="margin-bottom: 14px">
                <label class="input-title" style="width: 140px; margin-left: 10px;">Reference
                </label>
                <ul style="list-style-type: none" class="list-referrence">
                        <li v-for="(item, index) in listReferrence" >
                            <router-link target="_blank"  :to="{name: 'detailPost', params: {id: item.post_id_referrence}}">
                               {{item.post_name_referrence}}
                            </router-link>

                        </li>
                </ul>
            </div>


            <span class="comment-message-detail align-items-center position-relative">
                         <span> <span><img src="/assets/img/ic_cmt_28.png">{{countComment || 0}}</span>
                         <span><img src="/assets/img/ic_view_28.png"> {{ post.view || 0 }} </span> </span>
            </span><br/><br/>


        <hr/>

        <form class="form-comment position-relative mar-left-15" @submit.prevent="submitComment">
            <div class="comment-message d-flex">
                <input class="col-lg-12" type="hidden" v-model="commentPost.post_id">
                <label class="input-title" style="width: 140px; margin-left: 10px;">
                    Comment
                </label>
                <div id = "textarea-button" style="width: 84%;">
                <textarea class="form-control input-comment"
                          type="text"
                          rows="5"
                          v-model="commentPost.comment"
                          name="comment"
                          id="comment"
                          v-validate="'required'"
                          @change="changeInput('comment')"
                          placeholder="Comment here !"
                />
                    <button style="height: 50px;width: 70px" id="button-submit" class="btn btn-submit-comment">Submit</button>
                </div>
            </div>
            <div class="error-comment">
                <div v-show="errors.has('comment')" class="input-group text-danger" role="alert">
                    {{ errors.first('comment') }}
                </div>
                <div
                        v-if="sysError.comment"
                        class="input-group text-danger"
                        role="alert"
                >
                    {{ sysError.comment[0] }}
                </div>
            </div>
        </form>

        <div class="list-comment">

            <div class="item-comment d-flex" v-for="(item, index) in dataListComment">
                <div v-if="showEditComment && item.id === position" style="width: 100%;margin-bottom: 35px;">
                    <div class="col-lg-1">
                        <img v-if="item.user_image !== null && item.user_image !== ''" style="width: 44px;height: 44px" class="avatar-user-comment" :src="urlServerSSO + item.user_image">
                        <img v-else style="width: 44px;height: 44px" class="avatar-user-comment" src="/assets/img/avatar_default.png">

                    </div>

                    <textarea class="form-control input-edit-comment col-lg-10" type="text"
                              v-model="commentPostData.contentComment"
                              name="commentedit"
                              v-validate="'required'"
                              @change="changeInput('comment')"
                    />

                    <a  v-on:click="submitEdit($event, item)"
                        id="button-submit"
                        class="btn btn-default submit-comment btn btn-submit-comment">
                        Submit
                    </a>

                    <div v-show="errors.has('commentedit')" class="input-group text-danger" role="alert">
                        The comment field is required
                    </div>
                    <div
                            v-if="sysError.commentedit"
                            class="input-group text-danger"
                            role="alert"
                    >
                        {{ sysError.commentedit[0] }}
                    </div>
                </div>
                <!--commment user-->
                <div v-if="item.id !== position" class="content-comment">
                    <div>
                        <img v-if="item.user_image !== ''" style="width: 44px;height: 44px"  class="avatar-user-comment" :src="urlServerSSO + item.user_image">
                        <img v-else style="width: 44px;height: 44px" class="avatar-user-comment" src="/assets/img/avatar_default.png">
                    </div>
                  <div id = "comments-use" >

                      <div class="d-flex commment-button" style="min-width: 350px">
                          <span style="word-break: break-word" class="des-comment col-lg-11">
                              <div class="comment title" style="min-width: 250px">
                              {{ item.content }}
                              </div>
                          </span>
                          <svg v-if="item.user_id === userId"
                              xmlns="http://www.w3.org/2000/svg"
                              width="15" height="15" fill="currentColor"
                              class="bi bi-three-dots-vertical"
                              viewBox="0 0 16 16"
                              style="margin-left: 7px;margin-top: 12px;"
                              id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                          >
                              <path
                                  d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                          </svg>
                          <div v-if="item.user_id === userId" class="dropdown-menu col-lg-1" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" @click="editComment($event, item)">Edit</a>
                              <a class="dropdown-item" @click="deleteComment($event, item)">Delete</a>
                          </div>
                      </div>
                      <!--<textarea style ="border: none;background: rgb(255, 255, 255);height: 44px;overflow-y: hidden" disabled v-html="item.content" class="des-comment"></textarea>-->


                      <div class="user-date-comment">
                          <span class="user-comment text-secondary">{{ item.user_name }} </span>
                          &nbsp;
                          &nbsp;
                          <span class="date-comment text-secondary">{{ item.created_at | formatDate }}</span>
                      </div>
                  </div>
                </div>
                <!--end comment user -->
            </div>

        </div>
        <!--show dialog confirm-->

        <div id="dialog-container">
            <div class="dimBackground"  v-if=visibility>   </div>
            <div id="dialog" v-if=visibility>

                <h1>
                    {{title}}
                    <div>
                        <button  v-on:click="onClose()"  type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </h1>

                <div class="content">
                    {{content}}
                </div>

                <div class="button-confirm">
                    <button class="btn btn-default btn-confirm-cancel" v-on:click="onCancel()">
                        Close
                    </button>
                    <button class="btn btn-default btn-confirm-delete"  v-on:click="onDelete()">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
  import axios from "axios";
  import {URL_SERVER_SSO,IS_ADMIN} from "../../const";

  export default {
    data() {
      return {
        posts:[],
        post: {
          title: '',
          category_id: '',
          category_name: '',
          content: '',
          user_name: '',
          created_at: '',
          view:'',
          user_id:'',
          user_company:''
        },
        url: '/get-detail-post/',
        listAttachment:[],
        listReferrence:[],
        attachment:{
          name: '',
          size: '',
          path: '',
        },
        commentPost: {
          post_id: '',
          comment: '',
          contentComment:''
        },
        sysError: {},
        showEditComment: false,
        position: '',
        commentPostData: {
          commentId: '',
          contentComment: ''
        },
        dataListComment: '',
        countComment: '',
        visibility:false,
        title: 'Warning',
        content:'Are you sure you want to delete this post?',
        userInfo: [],
        isAdmin: 0,
        userId: 0,
        userCompany:'',
        urlServerSSO: URL_SERVER_SSO,
        IS_ADMIN: IS_ADMIN,
        hasAccess:false
      }
    },

    created() {
        let id = this.$route.params.id;
        this.getDetailPost(id);
        this.getUserInfo();
        this.viewPost(id);
        this.listCommentPost();
        this.closeWhenEscPress();
    },

    mounted()  {
    },
    methods: {
        getDetailPost(id){
            axios.get(this.url + id +'/detailPost')
                .then(response =>{
                  if(response.data.hasAccess === false){
                        this.$router.push('/');
                  }
                    let postData = response.data.post;

                    this.post.title          = postData.title;
                    this.post.content        = postData.content;
                    this.post.created_at     = postData.created_at;
                    this.post.category_id    = postData.category_id;
                    this.post.category_name  = postData.category_name;
                    this.post.user_name      = postData.user_name;
                    this.post.view           = postData.view;
                    this.post.user_id        = postData.user_id;

                    this.listAttachment =    response.data.listAttachment;
                    this.listReferrence = response.data.listReferrence;

                }).catch(error =>{
                console.log(error);
            });
        },

      getUserInfo()
      {
        var that = this;
        axios.get('/get-user-info').then(response=>{
          that.userInfo = response.data.infoUser;
          that.isAdmin = that.userInfo.is_admin;
          that.userId = that.userInfo.id;
      })
      },
      viewPost(id) {
        axios
          .get('/increment-view-post', {params: {postId: id}})
          .then((response) => {
            if (response.data.result) {

            }
          })
          .catch((err) => {

          });

      },

      zipAndDownload(){

        axios.get('/zip-and-download/' + 38)
          .then(response =>{


          }).catch(error =>{
          console.log(error);
        });
      },

      listCommentPost(){
        axios.get('/get-list-comment/' + this.$route.params.id)
          .then(response =>{
            this.dataListComment = response.data.comments;
            this.countComment = response.data.countComment;

          }).catch(error =>{
            console.log(error);
        });
      },

      showDialogConfirm(){
        this.visibility = true;
      },

      onCancel(){
        this.visibility = false;
      },

      onClose(){
        this.visibility = false;
      },

      closeWhenEscPress(){
        document.addEventListener("keydown", (e) => {
          if (e.keyCode === 27) {
            this.visibility = false;
          }
        });
      },

      onDelete(){
        this.visibility = false;
        var that = this;
        let postId = that.$route.params.id;

        axios.delete('/delete-post', {data: {postId: postId}})
          .then(response =>{
          window.location = '/';
        }).catch(error =>{
          console.log(error)
        })

      },

      download(filePath, fileName) {
        axios.get("/download-file", {params: {file: filePath}, responseType: 'blob'})
          .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', fileName);
            document.body.appendChild(link);
            link.click();
          })
          .catch(e => {
            console.log(e);
          });
      },

      submitComment() {
        this.commentPost.post_id = this.$route.params.id;
        var input = this.commentPost;
        var that = this;
        this.$validator.validateAll().then((valid) =>
        {
          if (valid) {
            this.$isLoading(true);
            axios
              .post('/create-comment', input)
              .then((response) => {
                if (response.data.result) {
                  this.$isLoading(false);
                  this.listCommentPost();
                  that.commentPost.comment = ""
                  that.$nextTick(() => that.$validator.reset())

                }
              })
              .catch((err) => {

              });
          }
        });
      },

      editComment(e, item) {
        this.showEditComment = true;
        this.position = item.id
        this.commentPostData.contentComment = item.content;
      },

      deleteComment(e, item) {
        const resIndex = this.dataListComment.findIndex(res => res.id === item.id);
        this.dataListComment.splice(resIndex, 1);
        this.messageToast = 'Delete successfully!'
        axios
          .delete('/delete-comment', {data: {commentId: item.id}})
          .then((response) => {
            if (response.data.result) {
              this.$toast.success(this.messageToast, {
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
              this.listCommentPost();
            } else {
              this.$toast.error("An error has occurred!", {
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
            if (err.response.data.message) {
              this.mess = err.response.data.message;
            } else {
              this.sysError = err.response.data;
            }
          });
      },

      submitEdit(e, item) {
        this.showEditComment = false;
        this.position = '';
        this.commentPostData.commentId = item.id;
        var input = this.commentPostData;

        axios
          .put('/edit-comment', input)
          .then((response) => {
            if (response.data.result) {
                this.listCommentPost();
            }
          })
          .catch((err) => {
            if (err.response.data.message) {
              this.mess = err.response.data.message;
            } else {
              this.sysError = err.response.data;
            }
          });
      },

      changeInput(fieldName) {
        this.$set(this.sysError, fieldName, null);
        this.mess = null;
      },
    }
  }
</script>
<style>
/*button*/
div#textarea-button {
    display: flex;
    width: 99%;
}
/*button*/
</style>
