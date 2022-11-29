<template>
    <div class="col-sm-12 search-and-list-post">

        <div class="document-list">
            <h4 class="document-list-title">
                <span>Document list</span>
            </h4>


            <router-link
                id="button-submit"
                    class="btn btn-new-post"
                    :to="{name: 'addPost'}"
            >

                Create Post
            </router-link>
        </div>

        <hr/>

        <div class="filter-blog">
            <div style="margin-top: 10px" class="search-between-date">
                <date-picker
                    v-model="fromDate"
                    format="DD-MM-YYYY"
                    type="date"
                    placeholder="Select from date"
                ></date-picker>

                <span style="margin-left: 5px;margin-right: 5px;font-weight: 600;padding-top: 6px">
                    ~
                </span>


                <date-picker
                    v-model="toDate"
                    format="DD-MM-YYYY"
                    type="date"
                    placeholder="Select to date"

                ></date-picker>

            </div>

            <div style="margin-top: 10px" class="col-xs-6 col-md-7 col-lg-5">
                <div class="input-group">
                    <input v-model="textSearch"
                           type="text"
                           class="form-control"
                           @keypress.enter="searchPost(1)"
                           placeholder="Enter title or submitler"/>

                </div>

            </div>

            <div class="input-group-btn">
                <button id="add-file" @click="searchPost(1)" class="btn btn-search-post" type="submit">
                    Search
                </button>
            </div>


            <br/>
            <table id = "customers" class="table list-post">
                <thead>
                <tr>
                    <th style="width: 30%;"  scope="col">Title</th>
                    <th style="width: 25%;" scope="col">Submitter</th>
                    <th style="width: 20%;"  scope="col">Department</th>
                    <th style="width: 20%;"  scope="col">
                        Created date
                        <i class="icon-sort-date"
                           :class="[!toggle ? 'fa-duotone fa fa-angle-up fa-xl' : 'fa-duotone fa fa-angle-down fa-xl']"
                           @click="sort('created_at'),toggle = !toggle">
                        </i>
                    </th>
                    <th style="width: 5%;" scope="col">Attach</th>
                </tr>
                </thead>

                <tbody >


                <tr v-if="hasPost" v-for="(post, index) in sortedList">
                    <router-link :to="{name: 'detailPost', params: {id: post.id}}" class="table-edit">
                        <td class="post-title text-truncate" style="max-width: 10px" v-bind:title="post.title">
                            {{post.title}}
                        </td>
                    </router-link>


                    <td v-bind:title="post.user_name">{{post.user_name}}</td>



                    <td v-bind:title="post.user_company">{{post.user_company}}</td>



                    <td  v-bind:title="post.created_at | formatOnlyDate">{{post.created_at | formatOnlyDate}}</td>


                    <td style="text-align: center;" :class="[{disablelClickDownload: post.has_attachment === 0}]">
                        <a  :href="'/zip-and-download/' + post.id">
                            <i class="bi bi bi-download fa-2xl"></i>
                        </a>
                    </td>
                </tr>


                </tbody>


                <tbody v-if="!hasPost">
                <tr>
                    <td colspan="5" style="text-align: center">No results</td>

                </tr>
                </tbody>

            </table>


            <pagination v-if="paginationSearch === false" v-bind:pagination="pagination"
                        v-on:click.native="getlistPost(pagination.current_page)" :offset="4"></pagination>

            <pagination v-if="paginationSearch === true" v-bind:pagination="pagination"
                        v-on:click.native="searchPost(pagination.current_page)" :offset="4"></pagination>
        </div>

    </div>
</template>

<script>
import Pagination from "./Pagination";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
  export default {
      components: { Pagination,DatePicker },
    name: 'ListPost',
    data(){
      return{
          toggle: false,
        posts: [],
        post: {
          title: '',
          user_name:'',
          user_company: '',
          created_at:''
        },
          pagination: {
              total: 0,
              per_page: 2,
              from: 1,
              to: 0,
              current_page: 1
          },
          offset: 4,
        url: '/get-list-post-by-category-id/',
        hasPost:false,
        fromDate: '',
        toDate: '',
        textSearch:'',
        paginationSearch :false,
          currentSort:'name',
          currentSortDir:'asc',
          isActive: false
      }
    },

    mounted()  {


      this.getlistPost(this.pagination.current_page);

    },

    methods:{
        //  sort to Title
        sort:function(s) {
            //if s == current sort, reverse

            if(s === this.currentSort) {
                this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
            }
            this.currentSort = s;


        },
      searchPost(page){
        axios.post('/search-post?page=' + page,{
          fromDate: this.fromDate,
          toDate: this.toDate,
          textSearch: this.textSearch,
          categoryId: this.$route.params.id
        })
          .then(result => {

            this.posts = result.data.data;
            this.pagination = result.data;

            if (result.data.data.length >0){
              this.paginationSearch = true;
            }
              if (this.posts.length > 0) {
                  this.hasPost = true;
              }
            if (this.posts.length === 0) {
              this.hasPost = false;
            }

          })
          .catch(err => {
            console.log(err);
          });
      },

      getlistPost(page)
      {
        var that = this;
        let res =  axios.get(that.url+this.$route.params.id + '?page=' + page).then(response=>{
          that.posts = response.data.listpost.data
            this.pagination = response.data.listpost


          if (that.posts.length > 0) {
            this.hasPost = true;
          }
        })


      },
    },

      computed:{
          //Sort TableList
          sortedList:function() {
              return this.posts.sort((a,b) => {
                  let modifier = 1;
                  if(this.currentSortDir === 'desc') modifier = -1;
                  if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                  if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                  return 0;
              });
          }
      }
  }
</script>

<style>

</style>
