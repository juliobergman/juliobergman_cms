<template>
    <v-app id="inspire">
        <app-bar></app-bar>
        <hero :height="heroHeight"></hero>
        <router-view :key="$route.path"></router-view>
    </v-app>
</template>

<script>
import AppBar from "./ui/appBar";
import Hero from "./ui/hero";
export default {
    components: {
        AppBar,
        Hero
    },
    data: () => ({
        heroHeight: "100vh"
    }),
    methods: {},
    created() {}
};
</script>

<style></style>
