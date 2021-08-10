<template>
    <v-app-bar color="appbar" dark flat dense app>
        <v-app-bar-nav-icon @click.stop="draw()"></v-app-bar-nav-icon>
        <v-spacer></v-spacer>
        <dark-mode-switch></dark-mode-switch>
    </v-app-bar>
</template>

<script>
import { bus } from "../../../app";
import DarkModeSwitch from "./darkMode";
export default {
    props: [""],
    components: { DarkModeSwitch },
    data: () => ({}),
    computed: {},
    methods: {
        draw() {
            bus.$emit("drawer:toggle");
        }
    },
    created() {}
};
</script>

<style></style>
