import Vue from "vue";
import VueRouter from "vue-router";

// App
import Account from "../components/app/account/container";
import Contents from "../components/app/contents/container";
import Section from "../components/app/section/container";
import Media from "../components/app/media/container";
import Settings from "../components/app/settings/container";
import Test from "../components/app/test/container.vue";
// Error
import Error404 from "../components/errors/404.vue";

Vue.use(VueRouter);

const routes = [
    // App
    {
        component: Account,
        name: "account",
        path: "/account",
        meta: { section: "account" }
    },
    {
        component: Section,
        name: "section",
        path: "/",
        meta: { section: "section" }
    },
    {
        component: Contents,
        name: "contents",
        path: "/contents",
        meta: { section: "contents" }
    },
    {
        component: Media,
        name: "media",
        path: "/media",
        meta: { section: "media" }
    },
    {
        component: Settings,
        name: "settings",
        path: "/settings",
        meta: { section: "settings" }
    },
    {
        component: Test,
        name: "test",
        path: "/test",
        meta: { section: "test" }
    },
    // Error 404
    {
        component: Error404,
        name: "error404",
        path: "*",
        meta: { section: "errors" }
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
