<template>
    <v-app id="inspire">
        <app-bar></app-bar>
        <hero></hero>
        <transition :name="transitionName" mode="out-in">
            <router-view :key="$route.path"></router-view>
        </transition>
    </v-app>
</template>

<script>
import { bus } from "../../app";
import AppBar from "./ui/appBar.vue";
import Hero from "./ui/hero.vue";
export default {
    components: {
        AppBar,
        Hero
    },
    data: () => ({
        transitionName: "slide-right"
    }),
    methods: {},
    created() {},
    mounted() {
        // Router Transitions
        this.$router.beforeEach((to, from, next) => {
            let toDepth = to.path.split("/").length;
            let fromDepth = from.path.split("/").length;
            this.transitionName =
                toDepth < fromDepth ? "slide-right" : "slide-left";
            // toDepth < fromDepth ? "fade" : "fade";

            if (to.meta.section != from.meta.section) {
                this.transitionName = "fade";
            }
            next();
        });
    }
};
</script>
