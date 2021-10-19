<template>
    <v-navigation-drawer v-model="drawer" :expand-on-hover="false" app>
        <!-- Card -->
        <drawer-user-card />
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
import DrawerUserCard from "./drawerUserCard.vue";
export default {
    props: [],
    components: { DrawerUserCard },
    data: () => ({
        selected: null,
        drawer: true,
        items: [
            {
                title: "Sections",
                icon: "mdi-view-dashboard",
                route: "section",
                section: "Section"
            },
            {
                title: "Contents",
                icon: "mdi-folder-text",
                route: "contents",
                section: "Contents"
            },
            {
                title: "Media",
                icon: "mdi-camera-iris",
                route: "media",
                section: "Media"
            },
            {
                title: "Settings",
                icon: "mdi-cog",
                route: "settings",
                section: "Settings"
            },
            {
                title: "Tests",
                icon: "mdi-test-tube",
                route: "test",
                section: "Test"
            }
        ]
    }),
    methods: {
        goto(route) {
            if (this.$route.name == route) return;
            this.$router.push({ name: route });
        },
        selectedItem() {
            this.items.findIndex((element, index) => {
                if (element.section == this.$route.meta.section) {
                    this.selected = index;
                }
            });
        }
    },
    created() {
        this.selectedItem();
        bus.$on("drawer:toggle", () => {
            this.drawer = !this.drawer;
        });
        bus.$on("go:to", this.goto);
        bus.$on("selected:item", this.selectedItem);
    },
    mounted() {
        this.$router.afterEach((to, from) => {
            this.selected = null;
        });
    }
};
</script>

<style></style>
