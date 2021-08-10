<template>
    <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                small
                icon
                class="mr-1"
                v-bind="attrs"
                v-on="on"
                @click="darkMode()"
            >
                <v-icon v-if="dmode">
                    mdi-white-balance-sunny
                </v-icon>
                <v-icon v-if="!dmode">
                    mdi-moon-waxing-crescent
                </v-icon>
            </v-btn>
        </template>
        <span v-if="dmode">Dark Mode</span>
        <span v-if="!dmode">Light Mode</span>
    </v-tooltip>
</template>

<script>
import { bus } from "../../../app";
export default {
    props: [],
    data: () => ({}),
    computed: {
        dmode() {
            return this.$vuetify.theme.dark;
        }
    },
    methods: {
        darkMode() {
            // this.bus.$emit("updateChart");
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
            localStorage.setItem(
                "dark_theme",
                this.$vuetify.theme.dark.toString()
            );
        }
    },
    created() {},
    mounted() {
        // Dark Theme
        const theme = localStorage.getItem("dark_theme");
        if (theme) {
            if (theme === "true") {
                this.$vuetify.theme.dark = true;
            } else {
                this.$vuetify.theme.dark = false;
            }
        } else if (
            window.matchMedia &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
        ) {
            this.$vuetify.theme.dark = true;
            localStorage.setItem(
                "dark_theme",
                this.$vuetify.theme.dark.toString()
            );
        }
    }
};
</script>

<style></style>
