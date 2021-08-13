<template>
    <v-app>
        <nav-drawer></nav-drawer>
        <app-bar></app-bar>
        <v-main>
            <router-view :key="$route.path"></router-view>
        </v-main>
    </v-app>
</template>

<script>
import AppBar from "./ui/appBar";
import NavDrawer from "./ui/navDrawer.vue";
export default {
    components: {
        AppBar,
        NavDrawer
    },
    data: () => ({}),
    methods: {},
    created() {}
};
</script>

<style></style>
