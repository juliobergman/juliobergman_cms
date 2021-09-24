import Vue from "vue";
import Vuex from "vuex";
import user from "./modules/user";
// import hero from "./modules/hero";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        loading: false,
        unsaved: false,
        webDrawer: false,
        content: {}
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
        },
        content(state, payload) {
            state.content = payload;
        }
    },
    actions: {
        setContent({ commit, state }, payload) {
            commit("loading", true);
            axios
                .post("/api/guest/content/show", payload)
                .then(response => {
                    commit("content", response.data);
                    commit("loading", false);
                })
                .catch(response => {
                    console.error(response);
                    console.error(response.message);
                });
        }
    },
    getters: {},
    modules: {
        user
        // hero
    }
});
