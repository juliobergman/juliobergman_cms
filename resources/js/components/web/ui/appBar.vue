<template>
    <v-app-bar
        fixed
        :shrink-on-scroll="shrink"
        :prominent="shrink"
        scroll-threshold="500"
        :class="barColor"
        dark
        flat
    >
        <v-container :class="barAlign + ' d-flex pa-0'">
            <v-avatar size="36">
                <v-img src="storage/ui/nav-logo.svg"></v-img>
            </v-avatar>

            <v-spacer></v-spacer>

            <v-btn-toggle
                v-if="!$isMobile()"
                tile
                group
                background-color="transparent"
                v-model="menuSelected"
                borderless
            >
                <v-btn
                    active-class="rounded"
                    small
                    text
                    v-for="(item, idx) in items"
                    :key="idx"
                    @click="goToRoute(item)"
                >
                    <v-icon
                        small
                        v-if="item.icon"
                        v-text="item.icon"
                        class="mr-2"
                    ></v-icon>
                    <span v-if="item.text" v-text="item.text"></span>
                </v-btn>
            </v-btn-toggle>
        </v-container>
    </v-app-bar>
</template>

<script>
import { bus } from "../../../app";
export default {
    data: () => ({
        barColor: "app-bar-transparent",
        barAlign: "mt-auto mb-1 align-center",
        barScroll: false,
        current: {},
        menuSelected: 0,
        items: [
            {
                text: "Projects",
                icon: "mdi-view-dashboard",
                to: "home",
                hero: "100vh"
            },
            {
                text: "Archive",
                icon: "mdi-folder",
                to: "archive",
                hero: "0px"
            },
            {
                text: "Development",
                icon: "mdi-laptop",
                to: "development",
                hero: "0px"
            },
            {
                text: "Contact",
                icon: "mdi-account",
                to: "contact",
                hero: "0px"
            }
        ]
    }),
    computed: {
        shrink() {
            return this.current.to != "home" ? false : true;
        }
    },
    methods: {
        goToRoute(item) {
            this.current = item;
            this.$router.push({ name: item.to });
            this.appBarColor();
        },
        appBarColor() {
            if (
                this.$router.currentRoute.name != "home" ||
                document.body.scrollTop > 505 ||
                document.documentElement.scrollTop > 505
            ) {
                this.barColor = "app-bar-color";
                this.barAlign = "my-auto align-center";
                this.barScroll = true;
            } else {
                this.barColor = "app-bar-transparent";
                this.barAlign = "mt-auto mb-1 align-center";
                this.barScroll = false;
            }
        }
    },
    created() {
        this.appBarColor();

        this.items.findIndex((element, index) => {
            if (element.to == this.$router.currentRoute.name) {
                this.menuSelected = index;
                this.current = element;
            }
        });
    },
    mounted() {
        window.onscroll = () => {
            this.appBarColor();
        };
        console.log(this.current.hero);
    },
    watch: {
        current() {
            bus.$emit("hero:height", this.current.hero);
        }
    }
};
</script>

<style scoped>
.app-bar-color {
    background-color: rgba(0, 0, 0, 0.7) !important;
}
.app-bar-transparent {
    background: rgba(0, 0, 0, 0) !important;
}
</style>
