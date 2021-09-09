<template>
    <v-app-bar
        fixed
        :shrink-on-scroll="shrink"
        :prominent="shrink"
        scroll-threshold="500"
        :class="barColor"
        dark
        flat
        style="z-index: 6;"
    >
        <v-container :class="barAlign + ' d-flex justify-space-between py-0'">
            <v-avatar size="36">
                <v-img src="storage/ui/nav-logo.svg"></v-img>
            </v-avatar>

            <v-spacer></v-spacer>

            <menu-desktop v-if="!$isMobile()" :items="itms"></menu-desktop>
            <menu-mobile v-if="$isMobile()" :items="itms"></menu-mobile>
        </v-container>
    </v-app-bar>
</template>

<script>
import { bus } from "../../../app";
import MenuDesktop from "./menuDesktop.vue";
import MenuMobile from "./menuMobile.vue";
import { items } from "./menuItems";
export default {
    components: {
        MenuDesktop,
        MenuMobile
    },
    data: () => ({
        barColor: "app-bar-transparent",
        barAlign: "mt-auto mb-1 align-center",
        barScroll: false,
        current: {}
    }),
    computed: {
        shrink() {
            return this.current.to != "home" || this.$isMobile() ? false : true;
        },
        itms() {
            return items;
        }
    },
    methods: {
        appBarColor() {
            if (
                this.$router.currentRoute.name != "home" ||
                this.$isMobile() ||
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

        items.findIndex((element, index) => {
            if (element.to == this.$router.currentRoute.name) {
                this.current = element;
            }
        });

        // Bus
        bus.$on("menu:go", item => {
            this.current = item;
            this.$router.push({ name: item.to });
            this.appBarColor();
        });
    },
    mounted() {
        window.onscroll = () => {
            this.appBarColor();
        };
    },
    watch: {
        current() {
            bus.$emit("hero:height", this.current.hero);
        }
    }
};
</script>

<style scoped>
.dm-btn {
    position: fixed;
    right: 0.7rem;
    top: 1rem;
}
.app-bar-color {
    background-color: rgba(0, 0, 0, 0.7) !important;
}
.app-bar-transparent {
    background: rgba(0, 0, 0, 0) !important;
}
</style>
