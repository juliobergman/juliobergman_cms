<template>
    <v-container>
        <!-- <v-img src="/storage/factory/stock/1.jpg"></v-img> -->
        <pt
            title="Work"
            subtitle="Branding | 3D Rendering | Photography | Development"
        />
        <projects></projects>
    </v-container>
</template>

<script>
import pt from "../ui/components/webTitle.vue";
import Projects from "./components/projects.vue";
export default {
    components: { pt, Projects },
    data: () => ({}),
    methods: {},
    created() {}
};
</script>

<style></style>
