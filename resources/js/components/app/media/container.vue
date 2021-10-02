<template>
    <v-container fluid>
        <v-toolbar dense flat v-if="currentCategory">
            <menu-select
                v-model="category"
                :items="categories"
                @input="menuChange"
            />
            <v-spacer></v-spacer>
            <v-slide-x-reverse-transition>
                <v-btn v-show="btnSave" icon @click="saveOrder()">
                    <v-icon color="accent">mdi-content-save</v-icon>
                </v-btn>
            </v-slide-x-reverse-transition>
            <v-btn icon @click="bulkBtn()">
                <v-icon color="accent" v-show="bulkActions">
                    mdi-checkbox-multiple-marked-outline
                </v-icon>
                <v-icon v-show="!bulkActions">
                    mdi-checkbox-multiple-blank-outline
                </v-icon>
            </v-btn>
            <upload-dialog
                v-model="category"
                :categories="categories"
                @update:done="getMedia()"
                @input="menuChange"
            />
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
                    <media-thumbnail
                        sortable
                        :selected="selectedItems.some(e => e == item.id)"
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

        <v-bottom-sheet
            v-model="bulkActions"
            hide-overlay
            persistent
            no-click-animation
            :retain-focus="false"
        >
            <v-card tile>
                <v-card-title class="text-subtitle-2">
                    Actions
                </v-card-title>
                <v-divider></v-divider>
                <v-card-actions class="align-center">
                    <v-btn
                        depressed
                        color="danger"
                        :dark="!selectedItems.length < 1"
                        :disabled="selectedItems.length < 1"
                        @click="bulkDelete()"
                    >
                        <v-icon class="mr-2">
                            mdi-delete
                        </v-icon>
                        Delete
                    </v-btn>
                    <v-spacer></v-spacer>
                    <!-- <menu-select
                        v-model="bulkData.category"
                        :items="categories"
                    /> -->
                    <div>
                        <v-select
                            v-model="bulkData.category"
                            :items="categories"
                            label="Move to Album"
                            item-text="name"
                            item-value="id"
                            hide-details
                            outlined
                            dense
                        >
                            <template v-slot:selection="{ item }">
                                <span>
                                    {{ item.name }}
                                </span>
                            </template>
                        </v-select>
                    </div>
                    <v-btn
                        text
                        class="mr-2"
                        @click="bulkData.public = !bulkData.public"
                    >
                        Public
                        <v-icon v-show="bulkData.public" class="ml-2">
                            mdi-checkbox-marked-outline
                        </v-icon>
                        <v-icon v-show="!bulkData.public" class="ml-2">
                            mdi-checkbox-blank-outline
                        </v-icon>
                    </v-btn>
                </v-card-actions>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="bulkBtn()">
                        Cancel
                    </v-btn>
                    <v-btn
                        text
                        :disabled="selectedItems.length < 1"
                        @click="bulkUpdate"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-bottom-sheet>
        <confirm ref="confirm"></confirm>
        <alert ref="alert"></alert>

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
        bulkActions: false,
        bulkData: {
            public: false,
            category: null
        },
        selectedItems: [],
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
        bulkBtn() {
            this.bulkActions = !this.bulkActions;
            this.selectedItems = [];
            this.bulkData = {
                public: false,
                category: parseInt(this.category, 10)
            };
        },
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
                .catch(error => {
                    // TODO
                    console.error(error.name);
                    console.error(error.message);
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
                .catch(error => {
                    // TODO
                    console.error(error.name);
                    console.error(error.message);
                });
        },
        show(item) {
            if (this.bulkActions) {
                let exists = this.selectedItems.some(e => e == item);
                if (!exists) {
                    this.selectedItems.push(item);
                }
                if (exists) {
                    this.selectedItems.splice(
                        this.selectedItems.indexOf(item),
                        1
                    );
                }
            }
            if (!this.bulkActions) {
                this.showMediaDialog = true;
                this.itemMediaDialog = this.media.find(e => e.id == item);
            }
        },
        saveOrder() {
            this.$store.commit("loading", true);
            axios
                .post("/api/media/update/bulk", this.media)
                .then(response => {
                    this.btnSave = false;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    // TODO
                    console.error(error.name);
                    console.error(error.message);
                });
        },
        bulkUpdate() {
            let postData = {
                items: this.selectedItems,
                public: this.bulkData.public,
                category: this.bulkData.category
            };
            console.log(postData);
        },
        bulkDelete() {
            console.clear();
            this.$refs.confirm
                .open(
                    null,
                    [
                        "Are you sure you want to delete this images?",
                        " - This action cannot be undone"
                    ],
                    {
                        color: "danger"
                    }
                )
                .then(confirmResponse => {
                    if (confirmResponse) {
                        this.$store.commit("loading", true);
                        axios
                            .delete("/api/upload/destroy/bulk", {
                                data: this.selectedItems
                            })
                            .then(response => {
                                this.getMedia();
                                let color = "success";
                                let title = null;
                                if (response.status == 202) {
                                    color = "warning";
                                    title = "Warning";
                                }
                                this.$refs.alert.open(
                                    title,
                                    response.data.messages,
                                    {
                                        color: color,
                                        messageAlign: "left"
                                    }
                                );
                                this.selectedItems = [];
                                this.$store.commit("loading", false);
                            })
                            .catch(error => {
                                console.error(error.response);
                                if (error.response.status == "404") {
                                    this.$refs.alert.open(
                                        "Error",
                                        error.response.data.errors,
                                        {
                                            color: "danger",
                                            messageAlign: "left"
                                        }
                                    );
                                }
                                this.$store.commit("loading", false);
                            });
                    }
                });
        }
    },
    created() {
        if (sessionStorage.getItem("media_category")) {
            this.category = sessionStorage.getItem("media_category");
        }
        this.bulkData.category = parseInt(this.category, 10);

        this.getMediaCategories();
        this.getMedia();
    },
    mounted() {}
};
</script>

<style>
.select-container {
    background: olivedrab;
}
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
