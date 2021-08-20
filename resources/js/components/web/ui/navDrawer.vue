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
                @click="goto(item)"
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
import { items } from "./menuItems";
import DarkModeSwitch from "../../app/ui/darkMode.vue";
export default {
    components: { DarkModeSwitch },
    data: () => ({
        drawer: false,
        selected: 0
    }),
    computed: {
        itms() {
            return items;
        }
    },
    methods: {
        goto(item) {
            bus.$emit("menu:go", item);
        }
    },
    created() {
        items.findIndex((element, index) => {
            if (element.to == this.$router.currentRoute.name) {
                this.selected = index;
            }
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
