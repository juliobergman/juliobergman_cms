<template>
    <v-app-bar fixed dark flat>
        <v-container fluid class="d-flex justify-space-between py-0 px-0">
            <v-avatar size="36">
                <v-img src="/storage/ui/nav-logo.svg"></v-img>
            </v-avatar>

            <v-spacer></v-spacer>

            <btn-drawer></btn-drawer>
        </v-container>
    </v-app-bar>
</template>

<script>
import btnDrawer from "./components/btnDrawer.vue";
export default {
    components: {
        btnDrawer
    },
    data: () => ({
        barColor: "app-bar-transparent",
        barAlign: "my-auto align-center",
        barScroll: false
    }),
    computed: {},
    methods: {},
    created() {},
    mounted() {
        window.onscroll = () => {};
    }
};
</script>

<style scoped></style>
