<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <v-toolbar-title>Media</v-toolbar-title>

            <v-spacer></v-spacer>

            <upload-dialog @update:done="getMedia()" />
        </v-toolbar>
        <v-divider></v-divider>

        <v-row class="mt-4">
            <v-col cols="6" sm="2" v-for="(item, idx) in media" :key="idx">
                <v-skeleton-loader type="image" :loading="!loaded">
                    <v-hover v-slot:default="{ hover }">
                        <v-card
                            flat
                            :elevation="hover ? 3 : 0"
                            class="cursor-pointer"
                            @click="show(item)"
                        >
                            <v-img :src="item.thumbnail" :aspect-ratio="1 / 1">
                                <v-fade-transition>
                                    <v-container
                                        fluid
                                        v-if="false"
                                        class="d-flex align-start justify-end pa-0 ma-0 img-overlay cursor-pointer"
                                    >
                                        <v-icon light class="mr-3 mt-2">
                                            mdi-eye
                                        </v-icon>
                                    </v-container>
                                </v-fade-transition>
                            </v-img>
                        </v-card>
                    </v-hover>
                </v-skeleton-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import UploadDialog from "./component/upload.vue";
export default {
    components: { UploadDialog },
    data: () => ({
        loaded: false,
        category: null,
        categories: [],
        media: []
    }),
    methods: {
        getMedia() {
            this.loaded = false;
            let postData = {
                category: this.category
            };
            axios
                .post("media/all", postData)
                .then(response => {
                    if (response.status == 200) {
                        this.media = response.data;
                        this.loaded = true;
                    }
                })
                .catch(response => {
                    console.error(response.name);
                    console.error(response.message);
                });
        },
        show(item) {
            console.log("show", item);
        }
    },
    created() {
        this.getMedia();
    }
};
</script>

<style scoped>
.img-overlay {
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.1);
}
.img-overlay div {
    width: 100%;
}
</style>
