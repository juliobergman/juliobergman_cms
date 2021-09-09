<template>
    <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon @click="dialog = true">
                <v-icon>mdi-upload</v-icon>
            </v-btn>
        </template>

        <v-card :loading="$store.state.loading">
            <v-card-title>
                File Upload
            </v-card-title>

            <v-card-text>
                <v-file-input
                    v-model="files"
                    placeholder="Upload your documents"
                    label="Media"
                    multiple
                    prepend-icon="mdi-paperclip"
                >
                    <template v-slot:selection="{ text }">
                        <v-chip small label color="primary">
                            {{ text }}
                        </v-chip>
                    </template>
                </v-file-input>
            </v-card-text>

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
    data: () => ({
        dialog: false,
        files: []
    }),
    computed: {
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
                    console.error(error);
                    console.error(error.response);
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
