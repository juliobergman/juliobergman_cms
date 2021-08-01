import Vue from "vue";
import VueRouter from "vue-router";

// Website Routes
import WebHome from "../components/web/home/container";
import WebContact from "../components/web/contact/container";
// App
import AppDashboard from "../components/app/dashboard/container";
import AppMedia from "../components/app/media/container";

Vue.use(VueRouter);

const routes = [
    {
        component: WebHome,
        name: "home",
        path: "/",
        meta: { section: "home" }
    },
    {
        component: WebContact,
        name: "contact",
        path: "/contact",
        meta: { section: "contact" }
    },
    // App
    {
        component: AppDashboard,
        name: "appDashboard",
        path: "/app/",
        meta: { section: "appDashboard" }
    },
    {
        component: AppMedia,
        name: "appMedia",
        path: "/app/media",
        meta: { section: "appMedia" }
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
