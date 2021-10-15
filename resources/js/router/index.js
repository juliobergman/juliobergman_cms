import Vue from "vue";
import VueRouter from "vue-router";

// Website Routes
import WebHome from "../components/web/home/container";
import WebMedia from "../components/web/media/container";
import WebDevelopment from "../components/web/development/container";
import WebLab from "../components/web/lab/container";
import WebContact from "../components/web/contact/container";
// WebsiteSubSections
import WebMediaLogos from "../components/web/media/container";
import WebCervezaBenitz from "../components/web/project/cervezabenitz.vue";

// App
import AppAccount from "../components/app/account/container";
import AppContents from "../components/app/contents/container";
import AppSection from "../components/app/section/container";
import AppMedia from "../components/app/media/container";
import AppSettings from "../components/app/settings/container";
import AppTest from "../components/app/test/container.vue";
// Error
import Error404 from "../components/web/ui/error/404.vue";

Vue.use(VueRouter);

const routes = [
    // Web
    {
        component: WebHome,
        name: "home",
        path: "/",
        meta: {
            section: "home"
        }
    },
    {
        component: WebMedia,
        name: "media",
        path: "/media",
        meta: { section: "media" }
    },
    {
        component: WebMediaLogos,
        name: "mediaLogos",
        path: "/media/logo",
        meta: { section: "media" }
    },
    {
        component: WebDevelopment,
        name: "dev",
        path: "/dev",
        meta: { section: "dev" }
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
    // Projects
    {
        component: WebCervezaBenitz,
        name: "cervezabenitz",
        path: "/project/cervezabenitz",
        meta: { section: "projects" }
    },
    // App
    {
        component: AppAccount,
        name: "appAccount",
        path: "/app/account",
        meta: { section: "appAccount" }
    },
    {
        component: AppSection,
        name: "appSection",
        path: "/app",
        meta: { section: "appSection" }
    },
    {
        component: AppContents,
        name: "appContents",
        path: "/app/contents",
        meta: { section: "appContents" }
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
