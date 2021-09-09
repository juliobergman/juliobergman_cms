import Vue from "vue";
import Vuex from "vuex";
import user from "./modules/user";
import media from "./modules/media";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        loading: false
    },
    mutations: {
        loading(state, payload) {
            state.loading = payload;
        }
    },
    actions: {},
    getters: {},
    modules: {
        user,
        media
    }
});
