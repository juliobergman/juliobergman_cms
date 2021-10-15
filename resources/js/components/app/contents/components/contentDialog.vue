<template>
    <v-dialog
        v-model="dialog"
        hide-overlay
        transition="dialog-bottom-transition"
        fullscreen
        @keydown="$store.commit('unsaved', true)"
    >
        <v-card flat tile>
            <v-progress-linear
                :active="$store.state.loading"
                :indeterminate="$store.state.loading"
                absolute
                top
                height="2"
                color="primary"
            ></v-progress-linear>
            <v-container fluid>
                <v-row>
                    <!-- Image Column -->
                    <v-col order="0" order-md="0" cols="12" md="6">
                        <media-dialog-image
                            v-if="item.cover_image"
                            :src="item.cover_image.large"
                            :remove-btn="item.cover ? true : false"
                            btn-text="Cover Image"
                            btn-icon="mdi-image-multiple-outline"
                            @action="replaceCover"
                            @remove="removeCover"
                        />
                    </v-col>
                    <!-- Information Column -->
                    <v-col order="1" order-md="1" cols="12" md="6">
                        <v-card flat>
                            <v-card-text class="mb-3 mb-md-6">
                                <v-text-field
                                    label="Title"
                                    v-model="item.name"
                                />
                                <v-text-field
                                    label="Subtitle"
                                    v-model="item.subtitle"
                                />
                                <v-text-field
                                    label="Path"
                                    v-model="item.path"
                                />
                                <v-text-field
                                    readonly
                                    label="Folio"
                                    v-model="item.folio"
                                />
                                <v-text-field
                                    label="Page Title"
                                    v-model="item.page_title"
                                />
                                <v-text-field
                                    label="SEO Info"
                                    v-model="item.seo_info"
                                />
                            </v-card-text>

                            <v-card-actions>
                                <v-btn text @click="close()">
                                    close
                                </v-btn>
                                <v-btn color="danger" text @click="destroy()">
                                    delete
                                </v-btn>
                                <v-spacer></v-spacer>
                                <v-btn
                                    :loading="$store.state.loading"
                                    :disabled="!$store.state.unsaved"
                                    text
                                    @click="save()"
                                >
                                    save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
        <confirm ref="confirm"></confirm>
        <alert ref="alert"></alert>
        <media-select
            v-model="item.cover"
            :dialog="mediaCover"
            @view="selectCover"
        />
    </v-dialog>
</template>

<script>
import MediaDialogImage from "../../media/components/mediaDialogImage.vue";
import MediaSelect from "../../media/components/mediaSelect.vue";
import { bus } from "../../../../app";
export default {
    components: {
        MediaDialogImage,
        MediaSelect
    },
    props: {
        value: Boolean,
        contentId: {}
    },
    data: () => ({
        mediaCover: false,
        item: [],
        public: [
            { name: "Yes", value: "yes" },
            { name: "No", value: "no" }
        ]
    }),
    computed: {
        dialog: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit("input", value);
            }
        },
        cid() {
            return this.contentId;
        }
    },
    methods: {
        getContent() {
            if (!this.cid) return;
            this.$store.commit("loading", true);
            axios
                .post("/api/content/data", { id: this.cid })
                .then(response => {
                    this.item = response.data;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    // TODO
                    console.error(error);
                    console.error(error.response);
                });
        },
        replaceCover() {
            this.mediaCover = true;
        },
        removeCover() {
            this.item.cover = null;
            this.selectCover(false);
        },
        selectCover(payload) {
            this.$store.commit("loading", true);
            this.mediaCover = payload;
            axios
                .post("/api/media/show", { id: this.item.cover })
                .then(response => {
                    if (response.data) {
                        this.item.cover_image = response.data;
                        this.$store.commit("unsaved", true);
                    }
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    // TODO
                    console.error(error);
                });
        },
        save() {
            this.$store.commit("loading", true);
            this.$store.commit("unsaved", false);

            axios
                .post("/api/content/update", this.item)
                .then(response => {
                    setTimeout(() => {
                        this.close();
                        this.$emit("saved", this.cid);
                        bus.$emit("content:update", this.cid);
                        this.$store.commit("loading", false);
                    }, 200);
                })
                .catch(error => {
                    // TODO
                    console.error(error);
                });
        },
        destroy() {
            if (this.item.album) {
                this.$refs.alert.open(
                    "Error",
                    [
                        "This Content is part of an Album",
                        "Please delete the album in the Media Section"
                    ],
                    {
                        color: "danger"
                    }
                );
                return;
            }

            this.$refs.confirm
                .open(null, ["Are you sure you want to delete this Content?"], {
                    color: "danger"
                })
                .then(confirmResponse => {
                    if (confirmResponse) {
                        this.$store.commit("loading", true);
                        axios
                            .delete("/api/content/destroy", { data: this.item })
                            .then(response => {
                                this.$refs.alert
                                    .open(null, response.data.messages)
                                    .then(() => {
                                        this.$emit("saved");
                                        this.close();
                                        this.$store.commit("loading", false);
                                    });
                            })
                            .catch(error => {
                                console.error(error);
                                console.error(error.response);

                                if (error.response.status == "405") {
                                    let errors = error.response.data.errors
                                        ? error.response.data.errors
                                        : [error.response.data.message];

                                    this.$refs.alert.open("Error", errors, {
                                        color: "danger",
                                        messageAlign: "left"
                                    });
                                }
                                this.$store.commit("loading", false);
                            });
                    }
                });
        },
        close() {
            if (this.$store.state.unsaved) {
                this.$refs.confirm
                    .open(
                        "Warning",
                        [
                            "You currently have unsaved changes, Are you sure you want to exit without saving?",
                            "Choose YES to leave without saving any changes."
                        ],
                        {
                            color: "warning",
                            messageAlign: "left",
                            btnCancel: "return",
                            width: 375
                        }
                    )
                    .then(confirmResponse => {
                        if (confirmResponse) {
                            this.$emit("reload");
                            setTimeout(() => {
                                this.$store.commit("unsaved", false);
                                this.dialog = false;
                                this.item = {};
                            }, 200);
                        }
                    });
            }
            if (!this.$store.state.unsaved) {
                this.dialog = false;
                this.item = {};
            }
        }
    },
    created() {},
    watch: {
        cid() {
            this.getContent();
        }
    }
};
</script>

<style scoped>
.btn-close {
    z-index: 10;
    position: absolute;
    right: 12px;
    top: 12px;
}
</style>
