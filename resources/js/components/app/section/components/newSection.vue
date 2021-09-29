<template>
    <v-dialog v-model="dialog" width="500" @input="reset()">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>
                    mdi-playlist-plus
                </v-icon>
            </v-btn>
        </template>

        <v-card :loading="$store.state.loading">
            <v-card-title>
                New Section
            </v-card-title>

            <v-card-text>
                <v-text-field label="Name" v-model="section.name" />
            </v-card-text>

            <v-card-text v-if="errors">
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

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn text @click="dialog = false">
                    Cancel
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn text @click="save()">
                    Create
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        errors: null,
        section: {
            name: ""
        }
    }),
    methods: {
        save() {
            this.$store.commit("loading", true);
            this.errors = null;
            axios
                .post("/api/section/store", this.section)
                .then(() => {
                    this.$emit("saved");
                    this.dialog = false;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.$store.commit("loading", false);
                });
        },
        reset() {
            this.section.name = "";
            this.errors = false;
        }
    }
};
</script>

<style></style>
