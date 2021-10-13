<template>
    <v-dialog v-model="dialog" :persistent="$store.state.loading" width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-btn :disabled="disabled" icon @click="dialog = true">
                <v-icon>mdi-upload</v-icon>
            </v-btn>
        </template>

        <v-card :loading="$store.state.loading">
            <v-card-title>
                File Upload
            </v-card-title>

            <v-card-text>
                <v-select
                    :disabled="$store.state.loading"
                    :items="mncat"
                    item-text="name"
                    item-value="id"
                    v-model="currentCategory"
                    label="Album"
                    prepend-icon="mdi-folder-open-outline"
                />
                <v-file-input
                    :disabled="$store.state.loading"
                    v-model="files"
                    placeholder="Upload your documents"
                    label="Media"
                    multiple
                    prepend-icon="mdi-paperclip"
                    @click:clear="errors = null"
                >
                    <template v-slot:selection="{ text }">
                        <v-chip small label color="primary">
                            {{ text }}
                        </v-chip>
                    </template>
                </v-file-input>
            </v-card-text>

            <v-slide-y-transition>
                <v-card-text v-show="errors">
                    <v-alert
                        dense
                        text
                        type="error"
                        v-for="(error, key) in errors"
                        :key="key"
                    >
                        {{ error[0] }}
                    </v-alert>
                </v-card-text>
            </v-slide-y-transition>

            <v-card-actions>
                <v-btn
                    :disabled="$store.state.loading"
                    text
                    @click="dialog = false"
                >
                    Cancel
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="uploadDisabled"
                    :loading="$store.state.loading"
                    text
                    @click="upload()"
                >
                    Upload
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "uploadDialog",
    props: {
        categories: Array,
        category: {},
        value: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
        errors: null,
        files: []
    }),
    computed: {
        mncat() {
            return this.categories;
        },
        dialog: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit("input", val);
            }
        },
        currentCategory: {
            get() {
                return this.categories.find(e => e.id == this.category);
            },
            set(val) {
                this.$emit("category", val);
            }
        },
        uploadDisabled() {
            return _.isEmpty(this.files);
        }
    },
    methods: {
        upload() {
            this.$store.commit("loading", true);
            let headers = {
                headers: {
                    "Content-Type": "multipart/form-data",
                    Accept: "application/json"
                }
            };

            let formData = new FormData();

            formData.append("category", this.currentCategory.id);

            this.files.forEach(e => {
                formData.append("image[]", e);
            });

            axios
                .post("/api/upload", formData, headers)
                .then(response => {
                    if (response.status == "200") {
                        this.files = [];
                        this.$store.commit("loading", false);
                        this.$emit("update:done");
                        this.dialog = false;
                    }
                })
                .catch(error => {
                    if ((error.response.status = 413)) {
                        this.errors = {
                            payload: [
                                "This payload is too large, try uploading your files in smaller batchs."
                            ]
                        };
                    } else {
                        this.errors = error.response.data.errors;
                    }
                    this.$store.commit("loading", false);
                });
        }
    },
    watch: {
        dialog() {
            if (this.dialog == false) {
                this.files = [];
            }
        }
    }
};
</script>

<style></style>
