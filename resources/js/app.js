import Vue from "vue";
import router from "./router";

// Plugins
// import Vuetify from "../plugins/vuetify";

// Main Pages
import GuestContainer from "../js/views/guest.vue";

const app = new Vue({
    router,
    // vuetify: Vuetify,
    components: { GuestContainer },
    el: "#app"
});
