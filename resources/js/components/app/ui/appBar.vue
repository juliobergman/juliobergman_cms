<template>
    <v-app-bar color="appbar" flat dense app>
        <v-app-bar-nav-icon @click.stop="draw()"></v-app-bar-nav-icon>
        <v-spacer></v-spacer>
        <dark-mode-switch></dark-mode-switch>
        <v-progress-linear
            :active="$store.state.loading"
            :indeterminate="$store.state.loading"
            absolute
            bottom
            height="2"
            color="primary"
        ></v-progress-linear>
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

<style scoped>
.v-application .appbar {
    border-bottom-color: rgba(0, 0, 0, 0.1) !important;
    border-bottom-style: solid !important;
    border-bottom-width: 1px !important;
}
</style>
