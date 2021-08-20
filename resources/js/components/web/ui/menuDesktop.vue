<template>
    <v-container class="justify-end align-center pa-0 ma-0 d-flex">
        <v-btn-toggle
            mandatory
            class="mr-2 d-none d-md-flex"
            tile
            group
            background-color="transparent"
            v-model="selected"
            borderless
        >
            <v-btn
                active-class="menu-active"
                class="rounded menu"
                small
                text
                v-for="(item, idx) in items"
                :key="idx"
                @click="$emit('menu:go', item)"
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
        <dark-mode-switch></dark-mode-switch>
    </v-container>
</template>

<script>
import DarkModeSwitch from "../../app/ui/darkMode.vue";
export default {
    props: ["items"],
    components: { DarkModeSwitch },
    data: () => ({
        selected: 0
    }),
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
