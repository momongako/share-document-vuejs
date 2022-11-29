<template>

  <div class="col-sm-12 search-and-list-post">
    <div class="form-add-category">
      <div class="detail-title">
        <span>
          Detail Category
        </span>
        <span>
          <router-link class="btn detail-category-button" :to="{ name: 'addCategory' }" id="button-submit">
            New Category
          </router-link>
        </span>
      </div>

      <hr />

      <form class="form-horizontal" enctype="multipart/form-data" @submit.prevent="updateCategory()">
        <div class="form-group">
          <label class="control-label col-sm-2 add-post-label" for="name">Category Name <span
              class="required">*</span></label>
          <div class="col-sm-9">
            <input v-model="name" type="text" class="form-control add-post-input " id="name" placeholder="" name="name"
              v-validate="'required|min:5|max:255'" @keyup="changeInput()">

            <div v-show="errors.has('name')" class="input-group text-danger" role="alert">
              {{ errors.first('name') }}
            </div>

            <span class="sysErrors" v-show="isVisibleError && errorName">{{ errorName }}</span>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2 add-post-label" for="description">Description</label>
          <div class="col-sm-9">
            <input v-model="description" type="text" class="form-control add-post-input" id="description" placeholder=""
              name="description" v-validate="'max:255'">

            <div v-show="errors.has('description')" class="input-group text-danger" role="alert">
              {{ errors.first('description') }}
            </div>

            <span class="sysErrors" v-show="isVisibleError && errorDescription">{{ errorDescription }}</span>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2 add-post-label" for="description">Status</label>
          <div class="col-sm-9">
            <div class="radio">
              <label class="category-status-public"><input v-model="status" type="radio" value="1" name="status"
                  checked>Public</label>
              <label><input v-model="status" type="radio" value="0" name="status">Private</label>
            </div>
          </div>
        </div>

        <hr />

        <div class="show-btn-submit-category">
          <div class="">

            <a href="javascript:;" v-on:click="showDialogConfirm()" class="btn btn-default">Delete</a>
            <button type="submit" id="button-submit" class="btn">Submit</button>
          </div>
        </div>
      </form>

      <!--show dialog confirm-->

      <div id="dialog-container">
        <div class="dimBackground" v-if=visibility> </div>
        <div id="dialog" v-if=visibility>

          <h1>
            {{ title }}
            <div>
              <button v-on:click="onClose()" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </h1>

          <div class="content">
            {{ content }}
          </div>

          <div class="button-confirm">
            <button class="btn btn-default btn-confirm-cancel" v-on:click="onCancel()">
              Close
            </button>
            <button v-if="!isDelete && !isSubmit" class="btn btn-default btn-confirm-delete" v-on:click="onDelete()">
              Confirm
            </button>
            <button v-if="isSubmit" class="btn btn-default btn-confirm-delete" v-on:click="onUpdate()">
              Confirm
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
import axios from "axios";
import { IS_ADMIN } from "../const";

export default {
  name: 'EditCategory',
  data() {
    return {
      name: '',
      description: '',
      status: 1,
      msg: '',
      errorName: '',
      errorDescription: '',
      isVisible: true,
      isVisibleError: true,
      visibility: false,
      title: 'Warning',
      content: 'Are you sure you want to delete this category ?',
      isDelete: false,
      isSubmit: false,
      statusOld: '',
      userInfo: [],
      hasAccess: false,
      isAdmin: '',
      IS_ADMIN: IS_ADMIN
    }
  },
  mounted() {
    let app = this;
    let id = app.$route.params.id;
    this.getUserInfo();

    // get list post by category id
    this.getListPostByCategoryId(id);

    // show
    axios.get('/category/' + id)
      .then(response => {
        if (response.data.hasAccess === false) {
          this.$router.push('/');
        }
        var category = response.data.category;
        this.name = category.name;
        this.description = category.description;
        this.status = category.status;
        this.statusOld = category.status;

      }).catch(error => {
        console.log(error);
      });

    this.closeWhenEscPress();
  },

  methods: {
    getUserInfo() {
      let that = this;
      axios.get('/get-user-info').then(response => {
        that.userInfo = response.data.infoUser;
        that.isAdmin = that.userInfo.is_admin;
      })
    },

    getListPostByCategoryId(id) {
      var that = this;
      axios.get(/get-list-post-by-category-id/ + id).then(response => {
        that.posts = response.data.listpost.data;
        if (that.posts.length > 0) {
          that.isDelete = true;
          that.content = "You cannot delete the category because there are already posts in this category.";
        }
      })
    },

    updateCategory() {
      var that = this;
      this.$validator
        .validateAll()
        .then((valid) => {
          if (valid) {
            that.submit();
          }
        })
        .catch(function (e) {
        });
    },

    submit() {

      var that = this;
      let id = that.$route.params.id;

      if (this.status == 1 && this.statusOld != this.status) {
        that.isSubmit = true;
        this.visibility = true;
        that.content = "All the posts of this category will be public. Are you sure you want to proceed?";
      }
      if (this.status == 0 && this.statusOld != this.status) {
        that.isSubmit = true;
        this.visibility = true;
        that.content = "All the posts of this category will be hidden from the users. Are you sure you want to proceed?";
      }

      if (this.statusOld == this.status) {
        axios.put('/category/' + id, {
          name: this.name,
          description: this.description,
          status: this.status

        }).then(response => {
          that.isVisible = true;
          that.isVisibleError = false;
          that.msg = 'Category Updated Successfully';
          this.$toast.success(that.msg, {
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

          setTimeout(function () {
            that.isVisible = false;
            window.location.href = '/';
          }, 1000);

        }).catch(error => {
          if (error.response.status === 422) {
            that.isVisibleError = true;
            if (error.response.data.errors.name) {
              that.errorName = error.response.data.errors.name[0];
            }
            if (error.response.data.errors.description) {
              that.errorDescription = error.response.data.errors.description[0];
            }
          }
        })
      }
    },

    changeInput() {
      this.errorName = '';
      this.isVisibleError = false;
    },

    showDialogConfirm() {
      this.visibility = true;
    },

    onDelete() {
      this.visibility = false;
      var that = this;
      let id = that.$route.params.id;
      axios.delete('/category/' + id).then(response => {
        window.location = '/';
      }).catch(error => {
        console.log(error)
      })

    },

    onUpdate() {
      this.visibility = false;
      var that = this;
      let id = that.$route.params.id;
      axios.put('/category/' + id, {

        name: this.name,
        description: this.description,
        status: this.status

      }).then(response => {

        that.isVisible = true;
        that.isVisibleError = false;
        that.msg = 'Updated Category';
        setTimeout(function () {
          that.isVisible = false;
          window.location.href = '/';
        }, 1000);
      }).catch(error => {
        if (error.response.status === 422) {
          that.isVisibleError = true;
          that.errorName = error.response.data.errors.name[0];
        }
      })
    },

    onCancel() {
      this.visibility = false;
    },

    onClose() {
      this.visibility = false;
    },

    closeWhenEscPress() {
      document.addEventListener("keydown", (e) => {
        if (e.keyCode === 27) {
          this.visibility = false;
        }
      });
    },
  }
}
</script>
