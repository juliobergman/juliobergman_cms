<template>
    <v-dialog
        v-model="dialog"
        hide-overlay
        transition="dialog-bottom-transition"
        fullscreen
    >
        <v-card flat tile>
            <v-container fluid>
                <v-row>
                    <!-- Image Column -->
                    <v-col order="0" order-md="0" cols="12" md="7">
                        <v-card flat>
                            <v-img
                                class="blackBack"
                                :contain="imgContain"
                                aspect-ratio="1"
                                :src="media.xlarge"
                                :lazy-src="media.thumbnail"
                            >
                                <template v-slot:placeholder>
                                    <v-row
                                        class="fill-height ma-0"
                                        align="center"
                                        justify="center"
                                    >
                                        <v-progress-circular
                                            indeterminate
                                            color="grey lighten-5"
                                        ></v-progress-circular>
                                    </v-row>
                                </template>

                                <v-container
                                    fluid
                                    fill-height
                                    class="align-end justify-end"
                                >
                                    <v-switch
                                        dark
                                        inset
                                        v-model="imgContain"
                                        label="Contain"
                                        class="mr-3"
                                    ></v-switch>
                                </v-container>
                            </v-img>
                        </v-card>
                    </v-col>
                    <!-- Information Column -->
                    <v-col order="1" order-md="1" cols="12" md="5">
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

                                <v-switch
                                    inset
                                    v-model="pub"
                                    label="Public"
                                    color="success"
                                ></v-switch>
                            </v-card-text>

                            <v-card-actions>
                                <v-btn @click="close()" text color="danger">
                                    cancel
                                </v-btn>
                                <v-spacer></v-spacer>

                                <v-btn @click="save()" text>
                                    save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
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
            axios
                .post("/api/media/store", this.item)
                .then(() => {
                    this.$emit("saved");
                })
                .catch(response => {
                    console.error(response);
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

<style></style>
