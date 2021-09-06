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
                    <v-col order="0" order-md="0" cols="12" md="7">
                        <cd-img
                            v-if="item.cover_image"
                            :src="item.cover_image.fullsize"
                            :mediaId="item.cover"
                            @select="selectCover"
                        />
                        <cd-img
                            v-if="item.og_image"
                            :src="item.og_image.fullsize"
                            :ar="1.91 / 1"
                            :mediaId="item.og_img"
                            @select="selectOG"
                        />
                    </v-col>
                    <!-- Information Column -->
                    <v-col order="1" order-md="1" cols="12" md="5">
                        <v-card flat>
                            <v-card-text class="mb-3 mb-md-6">
                                <v-select
                                    v-model="item.section_id"
                                    label="Section"
                                    :items="sections"
                                    item-text="name"
                                    item-value="id"
                                />

                                <v-text-field
                                    label="Name"
                                    v-model="item.name"
                                />
                                <v-text-field
                                    label="Path"
                                    v-model="item.path"
                                />
                                <v-text-field
                                    label="Page Title"
                                    v-model="item.page_title"
                                />
                                <v-text-field
                                    label="SEO Info"
                                    v-model="item.seo_info"
                                />

                                <v-text-field
                                    label="Cover ID"
                                    v-model="item.cover"
                                />

                                <v-text-field
                                    label="OG Image ID"
                                    v-model="item.og_img"
                                />

                                <v-switch
                                    inset
                                    v-model="pub"
                                    label="Public"
                                    color="success"
                                ></v-switch>
                            </v-card-text>

                            <v-card-actions>
                                <v-btn text @click="close()">
                                    close
                                </v-btn>
                                <v-spacer></v-spacer>
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
    </v-dialog>
</template>

<script>
import cdImg from "./contentImage.vue";
import confirm from "../../ui/alert/confirm.vue";
import alert from "../../ui/alert/alert.vue";
export default {
    components: {
        cdImg,
        confirm,
        alert
    },
    props: {
        value: Boolean,
        content: Object,
        sections: Array
    },
    data: () => ({
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
                return this.content;
            },
            set(content) {
                this.$emit("update", content);
            }
        },
        pub: {
            get() {
                return this.content.public == "yes" ? true : false;
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
        selectCover(image) {
            this.item.cover = image;
            this.item.cover_image = this.$store.state.media.data.find(
                e => e.id == image
            );
        },
        selectOG(image) {
            this.item.og_img = image;
            this.item.og_image = this.$store.state.media.data.find(
                e => e.id == image
            );
        },
        save() {
            this.$store.commit("loading", true);
            axios
                .post("/api/content/update", this.item)
                .then(response => {
                    this.$emit("saved");
                    this.close();
                    this.$store.commit("loading", false);
                })
                .catch(response => {
                    console.error(response);
                });
        },
        destroy() {
            return;
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
            this.dialog = false;
            this.item = {};
        }
    },
    created() {}
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
