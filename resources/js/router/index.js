import Vue from "vue";
import VueRouter from "vue-router";

// Website Routes
import WebHome from "../components/web/home/container";
import WebMedia from "../components/web/media/container";
import WebDevelopment from "../components/web/development/container";
import WebLab from "../components/web/lab/container";
import WebContact from "../components/web/contact/container";
// App
import AppAccount from "../components/app/account/container";
import AppPortfolio from "../components/app/portfolio/container";
import AppMedia from "../components/app/media/container";
import AppSettings from "../components/app/settings/container";
import AppTest from "../components/app/test/container";

Vue.use(VueRouter);

const routes = [
    // Web
    {
        component: WebHome,
        name: "home",
        path: "/",
        meta: { section: "home" }
    },
    {
        component: WebMedia,
        name: "media",
        path: "/media",
        meta: { section: "media" }
    },
    {
        component: WebDevelopment,
        name: "development",
        path: "/development",
        meta: { section: "development" }
    },
    {
        component: WebLab,
        name: "lab",
        path: "/lab",
        meta: { section: "lab" }
    },
    {
        component: WebContact,
        name: "contact",
        path: "/contact",
        meta: { section: "contact" }
    },
    // App
    {
        component: AppAccount,
        name: "appAccount",
        path: "/app/account",
        meta: { section: "appAccount" }
    },
    {
        component: AppPortfolio,
        name: "appPortfolio",
        path: "/app",
        meta: { section: "appPortfolio" }
    },
    {
        component: AppMedia,
        name: "appMedia",
        path: "/app/media",
        meta: { section: "appMedia" }
    },
    {
        component: AppSettings,
        name: "appSettings",
        path: "/app/settings",
        meta: { section: "appSettings" }
    },
    {
        component: AppTest,
        name: "appTest",
        path: "/app/test",
        meta: { section: "appTest" }
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
