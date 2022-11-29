import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const usersStore = new Vuex.Store({
    state: {
        detailPostCategory: '',
        listCommentPost: [],
        infoUser: {}
    },
    getters : {

    },
    mutations: {
        SET_DETAIL_POST_CATEGORY(state, detailPostCategory) {
            state.detailPostCategory = detailPostCategory
            state.listCommentPost = detailPostCategory.comment
        },
        ADD_COMMENT_POST(state, userComment) {
            state.listCommentPost.unshift(userComment)
        } ,
        SAVE_INFO_USER(state, infoUser) {
            state.infoUser = infoUser
        }
    },
    actions: {
        saveDetailPostCategory(context, detailPostCategory) {
            context.commit('SET_DETAIL_POST_CATEGORY', detailPostCategory)
        },
        addCommentPost(context, userComment) {
            context.commit('ADD_COMMENT_POST', userComment)
        },
        saveInfoUser(context, infoUser) {
            context.commit('SAVE_INFO_USER', infoUser)
        }
    }
});

export default usersStore;
