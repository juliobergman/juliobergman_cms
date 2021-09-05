<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <v-select
                v-model="category"
                :items="categories"
                item-text="name"
                item-value="id"
                hide-details
                hide-selected
                flat
                solo
                dense
                :append-icon="null"
                @change="getMedia()"
                class="title-select"
            >
                <template slot="selection" slot-scope="data">
                    <span class="text-button">{{ data.item.name }}</span>
                </template>
            </v-select>
            <v-spacer></v-spacer>
            <v-slide-x-reverse-transition>
                <v-btn v-show="btnSave" icon @click="saveOrder()">
                    <v-icon>mdi-content-save</v-icon>
                </v-btn>
            </v-slide-x-reverse-transition>
            <upload-dialog @update:done="getMedia()" />
        </v-toolbar>

        <draggable v-model="media" handle=".handle" @change="btnSave = true">
            <transition-group tag="div" class="row mt-4">
                <v-col
                    cols="6"
                    sm="2"
                    v-for="(item, idx) in media"
                    :key="item.id"
                >
                    <v-hover v-slot:default="{ hover }">
                        <v-card flat class="cursor-pointer" @click="show(item)">
                            <v-img :src="item.thumbnail" :aspect-ratio="1 / 1">
                                <v-fade-transition>
                                    <v-container
                                        fluid
                                        v-if="hover"
                                        class="d-flex pa-0 ma-0 img-overlay cursor-pointer"
                                    >
                                        <v-icon
                                            dark
                                            class="mb-auto mt-2 ml-2 mr-auto cursor-all-scroll handle"
                                            style="opacity: 0.6"
                                        >
                                            <!-- mdi-checkbox-blank-circle-outline -->
                                            mdi-cursor-move
                                        </v-icon>
                                    </v-container>
                                </v-fade-transition>
                            </v-img>
                        </v-card>
                    </v-hover>
                </v-col>
            </transition-group>
        </draggable>
        <media-dialog
            v-model="showMediaDialog"
            :media="itemMediaDialog"
            :categories="categories"
            @update="itemMediaDialog = $event"
            @saved="getMedia()"
        />
    </v-container>
</template>

<script>
import mediaDialog from "./component/mediaFile.vue";
import UploadDialog from "./component/upload.vue";
import draggable from "vuedraggable";
export default {
    components: { draggable, UploadDialog, mediaDialog },
    data: () => ({
        btnSave: false,
        showMediaDialog: false,
        itemMediaDialog: {},
        category: 1,
        categories: [],
        drag: false,
        dragging: false,
        edit: false,
        media: [],
        categories: []
    }),
    methods: {
        getMediaCategories() {
            this.$store.commit("loading", true);
            let postData = {
                public: null
            };
            axios
                .post("/api/media/categories", postData)
                .then(response => {
                    if (response.status == 200) {
                        this.categories = response.data;
                        this.$store.commit("loading", false);
                    }
                })
                .catch(response => {
                    console.error(response.name);
                    console.error(response.message);
                });
        },
        getMedia() {
            this.$store.commit("loading", true);
            let postData = {
                category: this.category
            };
            axios
                .post("/api/media", postData)
                .then(response => {
                    if (response.status == 200) {
                        this.media = response.data;
                        this.$store.commit("loading", false);
                    }
                })
                .catch(response => {
                    console.error(response.name);
                    console.error(response.message);
                });
        },
        show(item) {
            this.itemMediaDialog = item;
            this.showMediaDialog = true;
        },
        saveOrder() {
            this.$store.commit("loading", true);
            axios
                .post("/api/media/update/bulk", this.media)
                .then(response => {
                    if (response.status == 200) {
                        this.btnSave = false;
                        this.$store.commit("loading", false);
                    }
                })
                .catch(response => {
                    console.error(response.name);
                    console.error(response.message);
                });
        }
    },
    created() {
        this.getMediaCategories();
        this.getMedia();
    }
};
</script>

<style>
.title-select .v-input__slot {
    padding: 0 0px !important;
    background: none !important;
    width: fit-content;
    block-size: fit-content;
}
.img-overlay {
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.5);
}
</style>
