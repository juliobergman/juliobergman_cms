import Vue from "vue";
import Vuex from "vuex";
import user from "./modules/user";
// import hero from "./modules/hero";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        loading: false,
        unsaved: false,
        webDrawer: false
    },
    mutations: {
        loading(state, payload) {
            state.loading = payload;
        },
        unsaved(state, payload) {
            state.unsaved = payload;
        },
        webDrawer(state, payload) {
            state.webDrawer = payload;
        }
    },
    actions: {},
    getters: {},
    modules: {
        user
        // hero
    }
});
