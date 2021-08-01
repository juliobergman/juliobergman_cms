window._ = require("lodash");
window.axios = require("axios");
window.axios.defaults.headers.common["Accept"] = "application/json";
window.axios.defaults.headers.common["X-CSRF-TOKEN"] = document.querySelector(
    'meta[name="csrf-token"]'
)["content"];

import Vue from "vue";
import router from "./router";

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
    router,
    vuetify,
    components: { GuestContainer, ViewLogin, AppContainer },
    el: "#app"
});
