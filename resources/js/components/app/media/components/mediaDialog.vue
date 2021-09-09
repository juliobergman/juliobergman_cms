<template>
    <v-dialog
        v-model="dialog"
        hide-overlay
        transition="dialog-bottom-transition"
        fullscreen
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
                            :contain="imgContain"
                            :src="media.fullsize"
                            :lazySrc="media.thumbnail"
                            btn-text="Replace"
                            btn-icon="mdi-image-multiple-outline"
                            @action="replace"
                        />
                    </v-col>
                    <!-- Information Column -->
                    <v-col order="1" order-md="1" cols="12" md="6">
                        <v-card flat>
                            <v-card-text class="mb-3 mb-md-6">
                                <v-select
                                    v-model="item.category_id"
                                    label="Category"
                                    :items="categories"
                                    item-text="name"
                                    item-value="id"
                                />

                                <v-text-field
                                    label="Name"
                                    v-model="item.name"
                                />
                                <v-text-field
                                    label="Alt Text"
                                    v-model="item.alt"
                                />

                                <v-textarea
                                    v-model="item.info"
                                    label="Info"
                                ></v-textarea>
                                <div
                                    class="d-flex justify-space-around justify-md-start"
                                >
                                    <v-switch
                                        inset
                                        v-model="imgContain"
                                        label="Contain"
                                        class="ml-3"
                                    />
                                    <v-switch
                                        inset
                                        v-model="pub"
                                        label="Public"
                                        class="ml-6"
                                    />
                                </div>
                            </v-card-text>

                            <v-card-actions>
                                <v-btn text @click="close()">
                                    close
                                </v-btn>
                                <v-spacer></v-spacer>
                                <v-btn text @click="destroy()" color="danger">
                                    delete
                                </v-btn>
                                <v-btn text @click="save()">
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
        <v-file-input
            v-show="false"
            id="image"
            name="image"
            ref="image"
            @change="replaceImage"
        ></v-file-input>
    </v-dialog>
</template>

<script>
import MediaDialogImage from "./mediaDialogImage.vue";
import confirm from "../../ui/alert/confirm.vue";
import alert from "../../ui/alert/alert.vue";
export default {
    components: {
        MediaDialogImage,
        confirm,
        alert
    },
    props: {
        value: Boolean,
        media: Object,
        categories: Array
    },
    data: () => ({
        imgContain: true,
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
        item: {
            get() {
                return this.media;
            },
            set(media) {
                this.$emit("update", media);
            }
        },
        pub: {
            get() {
                return this.media.public == "yes" ? true : false;
            },
            set(value) {
                if (value) this.item.public = "yes";
                if (!value) this.item.public = "no";
            }
        },
        tbColor() {
            return this.$vuetify.theme.dark
                ? "rgba(30,30,30,0.6)"
                : "rgba(255,255,255,0.6)";
        }
    },
    methods: {
        save() {
            this.$store.commit("loading", true);
            axios
                .post("/api/media/store", this.item)
                .then(() => {
                    this.$emit("saved");
                    this.$store.commit("loading", false);
                })
                .catch(response => {
                    console.error(response);
                });
        },
        replace() {
            document.getElementById("image").click();
        },
        replaceImage(e) {
            this.$store.commit("loading", true);
            let formData = new FormData();

            formData.append("image", e);
            formData.append("id", this.media.id);

            let axiosHeaders = {
                headers: {
                    "Content-Type": "multipart/form-data",
                    Accept: "application/json"
                }
            };

            axios
                .post("/api/upload/replace", formData, axiosHeaders)
                .then(response => {
                    this.item = response.data;
                    this.$emit("saved");
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.response);
                });
        },
        destroy() {
            this.$refs.confirm
                .open(null, "Are you sure you want to delete this image?", {
                    color: "danger"
                })
                .then(confirmResponse => {
                    if (confirmResponse) {
                        this.$store.commit("loading", true);
                        axios
                            .delete("/api/upload/destroy", { data: this.media })
                            .then(response => {
                                if (response.status == 200) {
                                    this.$refs.alert
                                        .open(null, response.data.message)
                                        .then(() => {
                                            this.$emit("saved");
                                            this.close();
                                            this.$store.commit(
                                                "loading",
                                                false
                                            );
                                        });
                                }
                            })
                            .catch(error => {
                                console.error(error);
                                console.error(error.response);
                            });
                    }
                });
        },
        close() {
            this.item = {};
            this.dialog = false;
        }
    },
    created() {
        let mciLocalStorage = localStorage.getItem("media_contain_image");
        if (mciLocalStorage) this.imgContain = mciLocalStorage === "true";
    },
    watch: {
        imgContain() {
            localStorage.setItem("media_contain_image", this.imgContain);
        }
    }
};
</script>

<style scoped></style>
