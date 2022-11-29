<template>
    <div class="row content">
        <div style="margin-top: -20px" class="col-sm-2 col-md-2 col-lg-2 col-xl-2 sidenav sidenav bg-white ">
            <div class="show-list-document">
                <h4 class="document">
                <router-link
                    :class="[{active: $route.name === 'index'}]"
                    :to="{name: 'index'}"
                >
                    Document
                </router-link>
                </h4>
                <span class = "style-button-document" style="margin-left: -15px">
                       <i style="position: relative;right: 10px"
                          :class="[toggle_document ? 'fa-duotone fa fa-angle-up fa-lg' : 'fa-duotone fa fa-angle-down fa-lg']"
                          @click="toggle_document = !toggle_document">
                       </i>
                </span>

            </div>

            <div style="max-height: 300px;overflow-y: auto">
                <ul class="nav flex-column" v-show='!toggle_document'>

                    <li class="nav-item" v-for="(category, index) in categories">
                        <router-link
                            class="text-truncate" style="max-width: 190px;"
                            :to="{name: 'getListPost', params: {id: category.id}}"
                            :class=" [{active: $route.name === 'getListPost' && $route.params.id === category.id}]"
                        >
                            <!--table category-->
                            <div class="nav-item category-folder-show text-truncate"
                                 style="max-width: 190px;" id="category-edit">
                                <span class="bi bi-folder fa-lg"></span>
                                <span v-bind:title="category.name">{{category.name}}</span>
                            </div>
                        </router-link>

                    </li>
                </ul>
            </div>

            <br>
            <!--Category-->
            <div v-if="isAdmin === IS_ADMIN" class=" show-list-category">
                <span>
                   <div class="show-form-add">
                       <div
                           class="nav-link "

                       >
                          <h4 style="font-size: 16px;font-weight: 600">Category</h4>

                       </div>
                   </div>

                   <span class = "style-button" style="margin-left: -15px">

                       <i style="position: relative;right: 10px"
                          :class="[toggle ? 'fa-duotone fa fa-angle-up fa-lg' : 'fa-duotone fa fa-angle-down fa-lg']"
                          @click="toggle = !toggle">
                           </i>
                   </span>
                </span>
            </div>

            <div v-if="isAdmin === IS_ADMIN" style="max-height: 300px;overflow-y: auto">
                <ul class="nav flex-column list-category">
                    <li style="font-weight: 600;" v-show='!toggle'
                        class="nav-item category-folder-show">
                        <router-link
                            :class="[{active: $route.name === 'addCategory'}]"
                            :to="{name: 'addCategory'}"
                        >
                            <i class="bi bi-folder-plus fa-lg"></i>  &nbsp; New Category
                        </router-link>

                    </li>
                    <li v-for="(category, index) in categories" v-show='!toggle'
                        class="nav-item category-folder-show" id="category-edit">
                        <router-link
                            class="text-truncate" style="max-width: 190px;"
                            :class="[{active: $route.name === 'editCategory' && $route.params.id === category.id}]"
                            :to="{name: 'editCategory', params: {id: category.id}}"
                        >
                            <span class="bi bi-folder fa-lg"></span>
                            <span v-bind:title="category.name">{{category.name}}</span>
                        </router-link>
                    </li>
                </ul>
            </div>


        <!--end Category-->
        </div>

        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 main-content position-relative border-radius-lg">
            <router-view :key="$route.fullPath"></router-view>
        </div>
    </div>
</template>

<script>
import {IS_ADMIN} from "../const";
export default {
    name: 'HomePage',
    data(){
        return{
            toggle: false,
            toggle_document: false,
            categories: [],
            category: {
                id:0,
                name: '',
                description:'',
                status: ''
            },
            url: '/category',
            isActive: false,
            userInfo:[],
            isAdmin: 0,
            IS_ADMIN: IS_ADMIN
        }
    },

    mounted()  {
        this.getUserInfo();
        this.getCategories();
    },

    methods:{

        getUserInfo()
        {
            var that = this;
            axios.get('/get-user-info').then(response=>{
                that.userInfo = response.data.infoUser;
                that.isAdmin = that.userInfo.is_admin;
            })
        },

        getCategories()
        {
            var that = this;
            axios.get(that.url).then(response=>{
                that.categories = response.data
            })
        },
    }
}
</script>

<style>

.container {
    border: 1px solid #eee;
}
.active {
    color: #6AB04C!important;
}
.show-form-add{
    position: relative;
    top: -26px;
    left: -21px;
}
.show-form-add a{
    font-size: 16px;
    color: #333333;
    padding-left: 0px;
}
.document a{
    color: #333333;
    font-size: 16px;
    font-weight: 600;
}
a{
    text-decoration: none;
}
a:focus, a:hover {
    color: #23527c;

    text-decoration: none;
}
/*    aside-left*/
aside.col-sm-2.sidenav.sidenav.bg-white {
    border: 1px solid #FAFAFA;
    display: flex;
    flex-direction: column;
    padding: 20px 20px 490px;
    gap: 12px;
    position: absolute;
    height: 100%;
    left: 0px;
    background-color: #fbfbfb !important;
}
span.style-button {
    position: relative;
    top: -60px;
    /*left: 269px;*/
}

/*main-table*/

@media screen and (min-width: 1440px) {
    span.style-button {
        left: 204px !important;
    }
    span.style-button-document{
        left: 225px !important;
    }
    .nav>li>a {
        padding-bottom: 4.6px !important;
    }
}
@media screen and (min-width: 1600px) {
    span.style-button {
        left: 225px !important;
    }
    span.style-button-document{
        left: 245px !important;
    }
    .nav>li>a {
        padding-bottom: 4.6px !important;
    }
}

@media screen and (min-width: 1920px) {
    span.style-button {
        left: 269px !important;
    }
    span.style-button-document{
        left: 289px !important;
    }
    .nav>li>a {
        padding-bottom: 4.6px !important;
    }
}

@media screen and (min-width: 1366px) {
    span.style-button {
        left: 180px;
    }
    span.style-button-document{
        left: 200px ;
    }
}


/*end-main- table*/
nav>li>a:focus, .nav>li>a:hover {
    text-decoration: none;
    border-radius: 10px;
    color: #6AB04C;
}
a:active, a:hover {
    outline: 0;
    color: #6AB04C;
}
a:focus {
    color: #6AB04C;
    text-decoration: none;
}
.nav>li>a:focus, .nav>li>a:hover,document>a:focus {
    text-decoration: none;
    background-color: #fbfbfb;
    border-radius: 10px;
    color: #6AB04C;
}

/*button show,hide*/
span.style-button-document {
    position: relative;
    left: 200px;
    bottom: 30px;
}
.show-list-document {
    width: 0px;
    height: 9px;
    padding-bottom: 30px;
}
/*end button show,hide*/
</style>
