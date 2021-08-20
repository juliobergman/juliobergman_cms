<template>
    <v-container class="justify-end align-center pa-0 ma-0 d-flex">
        <v-btn @click="draw()" icon small>
            <v-icon>
                mdi-dots-vertical
            </v-icon>
        </v-btn>
    </v-container>
</template>

<script>
import { bus } from "../../../app";
import DarkModeSwitch from "../../app/ui/darkMode.vue";
export default {
    props: ["items"],
    components: { DarkModeSwitch },
    data: () => ({
        selected: 0
    }),
    methods: {
        draw() {
            bus.$emit("drawer:toggle");
        }
    },
    created() {
        this.items.findIndex((element, index) => {
            if (element.to == this.$router.currentRoute.name) {
                this.selected = index;
            }
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
