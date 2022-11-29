<template>
    <div class="col-sm-12 search-and-list-post">
        <div class=" form-add-category" >
            <h4 class="new-category-title"><span>Create a new Category</span></h4>
            <hr/>
            <form class="form-horizontal" enctype="multipart/form-data" @submit.prevent="createCategory()">
                <div class="form-group">
                    <label class="control-label col-sm-2 add-post-label" for="name">Category Name <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text"
                               class="form-control add-post-input"
                               id="name" placeholder=""
                               name="name"
                               v-model="category.name"
                               v-validate="'required|min:5|max:255'"
                               @keyup="changeInput()"
                        >

                        <div v-show="errors.has('name')" class="input-group text-danger" role="alert">
                            {{ errors.first('name') }}
                        </div>

                        <span class="sysErrors" v-show="isVisibleError && errorName">{{errorName}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 add-post-label" for="description">Description</label>
                    <div class="col-sm-9">
                        <input type="text"
                               class="form-control add-post-input"
                               id="description" placeholder=""
                               name="description"
                               v-model="category.description"
                               v-validate="'max:255'"
                        >

                        <div v-show="errors.has('description')" class="input-group text-danger" role="alert">
                            {{ errors.first('description') }}
                        </div>

                        <span class="sysErrors" v-show="isVisibleError && errorDescription">{{errorDescription}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 add-post-label" for="description">Status</label>
                    <div class="col-sm-9">
                        <div class="radio">
                            <label class="category-status-public"><input type="radio" value="1" name="status" checked v-model="category.status">Public</label>
                            <label><input type="radio" value="0" name="status" v-model="category.status">Private</label>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="show-btn-submit-category">
                    <div class="">

                        <router-link
                                class="btn btn-light"
                                :to="{name: 'index'}"
                        >
                            Cancel
                        </router-link>
                        <button type="submit" id="button-submit" class="btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
  import axios from "axios";
  import {IS_ADMIN} from "../const";

  export default {
    name: 'AddCategory',
    data(){
      return{
        category:{
          id:0,
          name: '',
          description:'',
          status: '1'
        },
        msg: '',
        errorName:'',
        errorDescription:'',
        isVisible:true,
        isVisibleError:false,
        userInfo: [],
        hasAccess:false,
        isAdmin: '',
        IS_ADMIN: IS_ADMIN
      }
    },
    mounted()  {
        this.getUserInfo();
    },
    methods:{

        getUserInfo()
        {
            let that = this;
            axios.get('/get-user-info').then(response=>{
                that.userInfo = response.data.infoUser;
                that.isAdmin = that.userInfo.is_admin;
                if(that.isAdmin === that.IS_ADMIN)
                {
                    that.hasAccess = false;
                }else{
                    this.$router.push('/');
                }
            })
        },

      createCategory(){
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
      changeInput() {
        this.errorName = '';
        this.isVisibleError = false;
      },

      submit(){
        var that = this;
        axios.post('/category', {
          name: this.category.name,
          description: this.category.description,
          status: this.category.status
        })
          .then(function (response) {

            that.isVisible = true;
            that.isVisibleError = false;
            that.msg = 'Category Added Successfully';

            that.$toast.success(that.msg, {
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

            setTimeout(function() {
              that.isVisible = false;
              window.location.href= '/';
            }, 1000);

          })
          .catch(function (error) {
            if (error.response.status === 422) {
              that.isVisibleError = true;
              if (error.response.data.errors.name){
                that.errorName = error.response.data.errors.name[0];
              }
              if (error.response.data.errors.description) {
                that.errorDescription = error.response.data.errors.description[0];
              }
            }
          });
      }

    }
  }
</script>

