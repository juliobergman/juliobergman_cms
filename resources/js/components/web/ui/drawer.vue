<template>
    <v-navigation-drawer
        color="rgba(0,0,0,0.6)"
        dark
        v-model="drawer"
        temporary
        right
        app
    >
        <v-list-item class="px-2">
            <v-btn @click="drawer = false" icon>
                <v-icon>
                    mdi-dots-vertical
                </v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <dark-mode-switch></dark-mode-switch>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item
                v-for="item in itms"
                :key="item.title"
                @click="goto(item.to)"
                link
            >
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.text }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import { bus } from "../../../app";
import { items } from "./assets/menuItems";
import DarkModeSwitch from "../../app/ui/darkMode.vue";
export default {
    components: { DarkModeSwitch },
    data: () => ({
        selected: 0
    }),
    computed: {
        itms() {
            return items;
        },
        drawer: {
            get() {
                return this.$store.state.webDrawer;
            },
            set(val) {
                this.$store.commit("webDrawer", val);
            }
        },
        content() {
            return this.$store.state.content;
        }
    },
    methods: {
        goto(route, mode) {
            if (mode == "name" || !mode) {
                this.$router.push({ name: route });
            }
            if (mode == "path") {
                this.$router.push({ path: route });
            }
            this.$store.dispatch("setContent", {
                path: this.$route.path
            });
            this.$store.commit("webDrawer", false);
        }
    },
    created() {
        bus.$on("goto:name", payload => {
            this.goto(payload, "name");
        });
        bus.$on("goto:path", payload => {
            this.goto(payload, "path");
        });
        bus.$on("drawer:set", payload => {
            this.drawer = payload;
        });
        bus.$on("drawer:toggle", () => {
            this.drawer = !this.drawer;
        });
    }
};
</script>

<style scoped>
.menu {
    color: rgba(255, 255, 255, 0.6);
}
.menu-active::before {
    background-color: transparent !important;
}
</style>
