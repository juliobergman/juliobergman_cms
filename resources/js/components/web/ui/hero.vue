<template>
    <v-sheet min-height="200px" :height="height" color="red" dark>
        <v-img height="100%" src="storage/factory/1.jpg">
            <v-container
                fluid
                class="d-flex align-end flex-row"
                :style="'min-height:200px; height: ' + height + ';'"
            >
            </v-container>
        </v-img>
    </v-sheet>
</template>

<script>
import { bus } from "../../../app";
export default {
    data: () => ({
        height: "0px"
    }),
    mounted() {
        bus.$on("hero:height", payload => {
            this.height = payload;
        });
    }
};
</script>

<style scoped></style>
