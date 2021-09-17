<template>
    <v-container class="justify-end align-center pa-0 ma-0 d-flex">
        <v-slide-x-reverse-transition>
            <v-btn
                @click="$store.commit('webDrawer', true)"
                icon
                small
                v-show="!$store.state.webDrawer"
            >
                <v-icon>
                    mdi-dots-vertical
                </v-icon>
            </v-btn>
        </v-slide-x-reverse-transition>
    </v-container>
</template>

<script>
import DarkModeSwitch from "../../app/ui/darkMode.vue";
export default {
    components: { DarkModeSwitch }
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
