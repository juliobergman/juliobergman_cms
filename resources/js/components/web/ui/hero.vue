<template>
    <v-sheet
        min-height="200px"
        class="black t-hero-duration"
        :height="height"
        dark
    >
        <v-img class="fill-height" src="storage/factory/1.jpg"> </v-img>
    </v-sheet>
</template>

<script>
import { bus } from "../../../app";
export default {
    data: () => ({
        loaded: true,
        height: "200px",
        hero: 1,
        big: false
    }),
    methods: {
        size(size) {}
    },
    computed: {
        cls() {
            return this.big ? "foo blue lg" : "foo blue sm";
        }
    },
    created() {},
    mounted() {
        bus.$on("hero:height", payload => {
            this.hero++;
            this.height = payload;
        });
    }
};
</script>
<style scoped>
* {
    will-change: height;
    transform: translateZ(0);
    backface-visibility: hidden;
    perspective: 1000px;
}
</style>
