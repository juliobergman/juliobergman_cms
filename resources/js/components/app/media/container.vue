<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <v-toolbar-title>Media</v-toolbar-title>

            <v-spacer></v-spacer>

            <upload-dialog @update:done="getMedia()" />
        </v-toolbar>
        <v-divider></v-divider>

        <v-row class="mt-4">
            <v-col cols="12" sm="2" v-for="(item, idx) in media" :key="idx">
                <v-img :src="item.thumbnail" :aspect-ratio="1 / 1" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import UploadDialog from "./component/upload.vue";
export default {
    components: { UploadDialog },
    data: () => ({
        category: null,
        categories: [],
        media: []
    }),
    methods: {
        getMedia() {
            let postData = {
                category: this.category
            };
            axios
                .post("media/all", postData)
                .then(response => {
                    if (response.status == 200) {
                        this.media = response.data;
                    }
                })
                .catch(response => {
                    console.error(response.name);
                    console.error(response.message);
                });
        }
    },
    created() {
        this.getMedia();
    }
};
</script>

<style></style>
