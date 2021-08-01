<template>
    <v-app id="inspire">
        <app-bar></app-bar>
        <router-view :key="$route.path"></router-view>
    </v-app>
</template>

<script>
import appBar from "./ui/appBar";
export default {
    components: {
        appBar
    },
    data: () => ({}),
    methods: {},
    created() {}
};
</script>

<style></style>
