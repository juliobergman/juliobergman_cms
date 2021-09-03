window._ = require("lodash");
window.axios = require("axios");
window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common["Accept"] = "application/json";
// window.axios.defaults.headers.common["X-CSRF-TOKEN"] = document.querySelector(
//     'meta[name="csrf-token"]'
// )["content"];

import "@mdi/font/css/materialdesignicons.css";
import Vue from "vue";
import router from "./router";
import store from "./store";
// Plugins
import vuetify from "../plugins/vuetify";
import VueMobileDetection from "vue-mobile-detection";
Vue.use(VueMobileDetection);
// Event BUS
export const bus = new Vue();

// Guest
import GuestContainer from "./components/web/container";
// Auth
import ViewLogin from "./components/auth/login";
// App
import AppContainer from "./components/app/container";

const app = new Vue({
    store,
    router,
    vuetify,
    components: { GuestContainer, ViewLogin, AppContainer },
    el: "#app"
});
