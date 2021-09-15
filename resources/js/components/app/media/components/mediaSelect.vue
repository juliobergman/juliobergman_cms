<template>
    <v-dialog
        v-model="show"
        hide-overlay
        transition="dialog-bottom-transition"
        fullscreen
    >
        <v-card flat tile>
            <v-container fluid>
                <v-progress-linear
                    :active="$store.state.loading"
                    :indeterminate="$store.state.loading"
                    absolute
                    top
                    height="2"
                    color="primary"
                ></v-progress-linear>
                <v-row>
                    <v-toolbar class="mb-2 mt-4" dense flat>
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
                                <span class="text-button">{{
                                    data.item.name
                                }}</span>
                            </template>
                        </v-select>
                        <v-spacer></v-spacer>
                        <v-btn text @click="show = false">
                            Cancel
                        </v-btn>
                        <v-btn text :disabled="!sel" @click="selectImage()">
                            Select
                        </v-btn>
                    </v-toolbar>
                </v-row>
                <v-row>
                    <v-col
                        cols="6"
                        sm="2"
                        v-for="(item, idx) in media"
                        :key="item.id"
                    >
                        <v-hover v-slot:default="{ hover }">
                            <v-card
                                flat
                                class="cursor-pointer"
                                color="grey darken-4"
                                @click="sel = item.id"
                            >
                                <v-img
                                    :aspectRatio="1 / 1"
                                    :src="item.thumbnail"
                                >
                                    <v-row
                                        v-if="hover || sel == item.id"
                                        no-gutters
                                        class="ma-0 fill-height cursor-pointer img-overlay"
                                        align="center"
                                        justify="center"
                                    >
                                        <v-icon
                                            large
                                            :color="
                                                sel == item.id
                                                    ? 'rgba(255,255,255,1)'
                                                    : 'rgba(255,255,255,0.5)'
                                            "
                                        >
                                            mdi-check-bold
                                        </v-icon>
                                    </v-row>
                                </v-img>
                            </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
                <v-footer padless absolute v-if="pageLength > 1" class="mb-2">
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
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        value: Number,
        dialog: {
            type: Boolean,
            default: false
        }
    },
    model: {
        prop: "value",
        event: "input"
    },
    data: () => ({
        category: 1,
        page: 1,
        pageLength: 1,
        categories: [],
        media: [],
        sel: null
    }),
    computed: {
        selected: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit("input", val);
            }
        },
        show: {
            get() {
                return this.dialog;
            },
            set(val) {
                this.$emit("view", val);
            }
        },
        pageRecords() {
            return this.$isMobile() ? 6 : 18;
        }
    },
    methods: {
        selectImage() {
            this.$emit("input", this.sel);
            this.show = false;
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
                .catch(response => {
                    console.error(response.name);
                    console.error(response.message);
                });
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
                    if (response.status == 200) {
                        this.media = response.data.data;
                        this.pageLength = response.data.last_page;
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
    },
    watch: {
        selected() {
            this.sel = this.selected;
        }
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
.pagination .v-pagination__navigation,
.pagination .v-pagination__item {
    box-shadow: none;
}
</style>
