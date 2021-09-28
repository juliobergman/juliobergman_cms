<template>
    <v-app id="application">
        <drawer />
        <app-bar />
        <hero :key="hero" />
        <v-main class="pb-16">
            <v-fade-transition mode="out-in">
                <router-view :key="$route.path"></router-view>
            </v-fade-transition>
        </v-main>
        <app-footer />
    </v-app>
</template>

<script>
import { bus } from "../../app";
import Drawer from "./ui/drawer.vue";
import AppBar from "./ui/appBar.vue";
import Hero from "./ui/hero.vue";
import appFooter from "./ui/footer.vue";
export default {
    components: {
        Drawer,
        AppBar,
        Hero,
        appFooter
    },
    data: () => ({
        hero: 0,
        tl: undefined,
        transitionName: "slide-right"
    }),
    methods: {
        enableScroll() {
            document.body.classList.remove("stop-scrolling");
        },
        disableScroll() {
            document.body.classList.add("stop-scrolling");
        }
    },
    created() {
        this.$store.dispatch("setContent", {
            path: this.$route.path
        });
    },
    mounted() {
        bus.$on("scroll:enable", this.enableScroll);
        bus.$on("scroll:disable", this.disableScroll);
        // Router Guards
        this.$router.beforeEach((to, from, next) => {
            // this.hero++;
            next();
        });
        this.$router.afterEach((to, from) => {
            this.gsap.to(window, {
                delay: 0.5,
                duration: 0.5,
                scrollTo: 0
            });
        });
    }
};
</script>
<style>
.stop-scrolling {
    height: 100vh !important;
    overflow: hidden !important;
}
</style>
