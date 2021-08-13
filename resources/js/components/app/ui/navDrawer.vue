<template>
    <v-navigation-drawer v-model="drawer" :expand-on-hover="false" app>
        <!-- Card -->
        <v-list-item class="px-2">
            <v-list-item-avatar>
                <v-img src="https://randomuser.me/api/portraits/men/85.jpg">
                </v-img>
            </v-list-item-avatar>

            <v-list-item-title>John Leider</v-list-item-title>

            <account-menu></account-menu>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item-group v-model="selected">
                <v-list-item
                    link
                    v-for="item in items"
                    :key="item.title"
                    @click="goto(item.route)"
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import { bus } from "../../../app";
import AccountMenu from "./accountMenu";
export default {
    props: [],
    components: { AccountMenu },
    data: () => ({
        selected: 0,
        drawer: true,
        items: [
            {
                title: "Portfolio",
                icon: "mdi-view-dashboard",
                route: "appPortfolio"
            },
            {
                title: "Media",
                icon: "mdi-camera-iris",
                route: "appMedia"
            },
            {
                title: "Settings",
                icon: "mdi-cog",
                route: "appSettings"
            },
            {
                title: "Tests",
                icon: "mdi-test-tube",
                route: "appTest"
            }
        ]
    }),
    methods: {
        goto(route) {
            if (this.$route.name == route) return;
            this.$router.push({ name: route });
        }
    },
    created() {
        bus.$on("drawer:toggle", () => {
            this.drawer = !this.drawer;
        });
        bus.$on("go:to", this.goto);
    }
};
</script>

<style></style>
