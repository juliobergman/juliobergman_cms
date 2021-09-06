import axios from "axios";

const state = {
    data: ""
};
const mutations = {
    setMedia(state, media) {
        state.data = media;
    }
};
const actions = {
    setMedia({ commit }) {
        commit("loading", true, { root: true });
        let postData = {
            category: null
        };
        axios
            .post("/api/media", postData)
            .then(response => {
                if (response.status == 200) {
                    commit("setMedia", response.data);
                    commit("loading", false, { root: true });
                }
            })
            .catch(response => {
                console.error(response.name);
                console.error(response.message);
            });
    }
};
const getters = {};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
