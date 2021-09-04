import axios from "axios";

const state = {
    data: ""
};
const mutations = {
    setUser(state, user) {
        state.data = user;
    }
};
const actions = {
    setUser({ commit }) {
        commit("loading", true, { root: true });
        axios
            .get("/api/user")
            .then(response => {
                commit("setUser", response.data);
                commit("loading", false, { root: true });
            })
            .catch(response => {
                console.error(response);
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
