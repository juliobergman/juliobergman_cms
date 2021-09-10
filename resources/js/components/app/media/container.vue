<template>
    <v-container fluid>
        <v-toolbar dense flat v-if="currentCategory">
            <menu-select
                v-model="category"
                :items="categories"
                :btnText="currentCategory.name"
                @input="menuChange"
            />
            <v-spacer></v-spacer>
            <v-slide-x-reverse-transition>
                <v-btn v-show="btnSave" icon @click="saveOrder()">
                    <v-icon>mdi-content-save</v-icon>
                </v-btn>
            </v-slide-x-reverse-transition>
            <upload-dialog @update:done="getMedia()" />
        </v-toolbar>

        <draggable
            v-model="media"
            handle=".handle"
            @change="btnSave = true"
            v-bind="dragOptions"
            @start="drag = true"
            @end="drag = false"
        >
            <transition-group tag="div" class="row mt-4">
                <v-col
                    cols="6"
                    sm="3"
                    v-for="(item, idx) in media"
                    :key="item.id"
                >
                    <!-- :aspectRatio="1 / 1" -->
                    <media-thumbnail
                        :media="item"
                        :src="item.medium"
                        @click="show"
                    />
                </v-col>
            </transition-group>
        </draggable>

        <v-footer padless absolute v-if="pageLength > 1">
            <v-card tile flat width="100%">
                <v-pagination
                    color="primary"
                    v-model="page"
                    :length="pageLength"
                    total-visible="7"
                    class="pagination"
                    @input="getMedia"
                ></v-pagination>
            </v-card>
        </v-footer>

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
import mediaThumbnail from "./components/mediaThumbnail.vue";
import draggable from "vuedraggable";
import mediaDialog from "./components/mediaDialog.vue";
import uploadDialog from "./components/mediaUploadDialog.vue";
import menuSelect from "../ui/menuSelect.vue";
export default {
    components: {
        menuSelect,
        draggable,
        mediaThumbnail,
        uploadDialog,
        mediaDialog
    },
    data: () => ({
        btnSave: false,
        drag: false,
        showMediaDialog: false,
        itemMediaDialog: {},
        category: 1,
        page: 1,
        pageLength: 1,
        categories: [],
        media: []
    }),
    computed: {
        dragOptions() {
            return {
                animation: 200,
                group: "description",
                disabled: false,
                ghostClass: "ghost"
            };
        },
        pageRecords() {
            return this.$isMobile() ? 6 : 12;
        },
        currentCategory() {
            return this.categories.find(e => e.id == this.category);
        }
    },
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
        menuChange($event) {
            this.page = 1;
            sessionStorage.setItem("media_category", $event);
            this.getMedia();
        },
        getMedia() {
            this.$store.commit("loading", true);
            let postData = {
                category: this.category,
                records: this.pageRecords
            };
            axios
                .post("/api/media?page=" + this.page, postData)
                .then(response => {
                    this.media = response.data.data;
                    this.pageLength = response.data.last_page;
                    this.$store.commit("loading", false);
                })
                .catch(response => {
                    console.error(response.name);
                    console.error(response.message);
                });
        },
        show(item) {
            this.itemMediaDialog = this.media.find(e => e.id == item);
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
        if (sessionStorage.getItem("media_category")) {
            this.category = sessionStorage.getItem("media_category");
        }
        this.getMediaCategories();
        this.getMedia();
    },
    mounted() {}
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
.pagination .v-pagination__navigation,
.pagination .v-pagination__item {
    box-shadow: none;
}
/* Draggable */
.button {
    margin-top: 35px;
}
.flip-list-move {
    transition: transform 0.5s;
}
.no-move {
    transition: transform 0s;
}
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}
.list-group {
    min-height: 20px;
}
.list-group-item {
    cursor: move;
}
.list-group-item i {
    cursor: pointer;
}
</style>
