<template>
    <v-app-bar class="ab" color="rgba(0,0,0,0.0001)" fixed dark flat>
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
    data: () => ({}),
    computed: {},
    methods: {},
    created() {},
    mounted() {
        this.gsap.to(".ab", {
            backgroundColor: "rgba(0,0,0,0.4)",
            ease: "none",
            scrollTrigger: {
                trigger: "body",
                scrub: true,
                start: "+=200",
                end: "+=500"
            }
        });
    }
};
</script>

<style scoped></style>
