<template>
    <v-navigation-drawer v-model="drawer" expand-on-hover app>
        <!-- Card -->
        <v-list-item class="px-2">
            <v-list-item-avatar>
                <v-img src="https://randomuser.me/api/portraits/men/85.jpg">
                </v-img>
            </v-list-item-avatar>

            <v-list-item-title>John Leider</v-list-item-title>

            <v-btn icon>
                <v-icon>mdi-account</v-icon>
            </v-btn>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item-group v-model="selected">
                <v-list-item v-for="item in items" :key="item.title" link>
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
export default {
    props: [],
    data: () => ({
        selected: 0,
        drawer: true,
        items: [
            {
                title: "Portfolio",
                icon: "mdi-view-dashboard",
                route: "app/portfolio"
            },
            {
                title: "Archive",
                icon: "mdi-archive",
                route: "app/archive"
            },
            {
                title: "Settings",
                icon: "mdi-cog",
                route: "app/settings"
            },
            {
                title: "Tests",
                icon: "mdi-test-tube",
                route: "app/test"
            }
        ]
    }),
    methods: {},
    created() {
        bus.$on("drawer:toggle", () => {
            this.drawer = !this.drawer;
        });
    }
};
</script>

<style></style>
