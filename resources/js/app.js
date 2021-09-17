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
import Particles from "particles.vue";

// GSAP
import { gsap } from "gsap";
import { ExpoScaleEase, RoughEase, SlowMo } from "gsap/EasePack";
import { CSSRulePlugin } from "gsap/CSSRulePlugin";
import { Draggable } from "gsap/Draggable";
import { EaselPlugin } from "gsap/EaselPlugin";
import { MotionPathPlugin } from "gsap/MotionPathPlugin";
import { PixiPlugin } from "gsap/PixiPlugin";
import { TextPlugin } from "gsap/TextPlugin";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(
    CSSRulePlugin,
    Draggable,
    EaselPlugin,
    MotionPathPlugin,
    PixiPlugin,
    TextPlugin,
    ScrollToPlugin,
    ScrollTrigger,
    ExpoScaleEase,
    RoughEase,
    SlowMo
);

Vue.mixin({
    created: function() {
        this.gsap = gsap;
    }
});

Vue.use(VueMobileDetection);
Vue.use(Particles);
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
