require('./bootstrap')

Vue.component('home-page', require('./components/HomePage'));
Vue.component('addCategory', require('./components/AddCategory'));

Vue.component('editCategory', require('./components/EditCategory'));
Vue.component('getListPost', require('./components/GetListPostByCategoryId'));
Vue.component('addPost', require('./components/commons/NewPost'));
Vue.component('detailPost', require('./components/commons/DetailPost'));
Vue.component('editPost', require('./components/commons/EditPost'));

import VueRouter from 'vue-router';

import Vue from 'vue';
import Vuetify  from "vuetify";
import VeeValidate from "vee-validate";
import store from "./store";
import HomePage from "./components/HomePage";
import moment from "moment"
import VueResource from 'vue-resource'
import VueSweetalert2 from 'vue-sweetalert2';
import Toast from "vue-toastification";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import loading from 'vuejs-loading-screen'

// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
import Vue2Editor from "vue2-editor";
import routes from './routes';

const options = {
    // You can set your default options here
};

// use router
Vue.use(VueRouter);
Vue.use(loading, {
  bg: 'rgba(255,0,0,0)',
  icon: 'fas fa-spinner',
  size: 5,
  icon_color: '#6AB04C',
})


Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(Toast, options)
Vue.use(VueResource)
Vue.use(Vuetify)
Vue.use(moment)
Vue.use(VeeValidate)
Vue.use(VueSweetalert2)
Vue.use(Vue2Editor)
Vue.filter('formatOnlyDate', function(value, format = null) {
    if (value) {
        if (format) {
            return moment(String(value)).format('HH:mm')
        }

        return moment(String(value)).format('DD/MM/YYYY')
    }
});

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY HH:mm')
    }
});

Vue.filter('stripHTML', function (value) {
    const div = document.createElement('div')
    div.innerHTML = value
    const text = div.textContent || div.innerText ||  " "
    return text
});

Vue.directive("click-outside", {
    bind(el, binding, vnode) {
        el.clickOutsideEvent = (event) => {
            if (!(el === event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener("click", el.clickOutsideEvent);
    },
    unbind(el) {
        document.body.removeEventListener("click", el.clickOutsideEvent);
    },
});

const router = new VueRouter({
  routes,
  mode: 'hash'
});

new Vue({
    store,
    created() {},
    el: '#app',
  router,
    components: {
        HomePage
    },
    methods: {},
    mounted() {},
});

