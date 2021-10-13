<template>
    <v-dialog v-model="dialog" max-width="375" @input="reset()">
        <template v-slot:activator="{ on, attrs }">
            <v-btn v-if="!hidden" icon v-bind="attrs" v-on="on">
                <v-icon>
                    mdi-image-multiple-outline
                </v-icon>
            </v-btn>
        </template>

        <v-card :loading="$store.state.loading">
            <v-card-title>
                New Album
            </v-card-title>

            <v-card-text>
                <v-text-field
                    label="Name"
                    v-model="name"
                    @keyup="errors = null"
                />
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

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn
                    text
                    :disabled="$store.state.loading"
                    @click="dialog = false"
                >
                    Cancel
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn text :loading="$store.state.loading" @click="save()">
                    Create
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        hidden: {
            type: Boolean,
            default: false
        },
        value: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
        errors: null,
        name: ""
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
        folio() {
            return _.trim(_.kebabCase(this.name));
        }
    },
    methods: {
        save() {
            this.$store.commit("loading", true);
            this.errors = null;
            axios
                .post("/api/media/category/store", {
                    name: this.name,
                    folio: this.folio
                })
                .then(response => {
                    this.$emit("saved", response.data.created);
                    this.dialog = false;
                    this.name = "";
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.$store.commit("loading", false);
                });
        },
        reset() {
            this.name = "";
            this.errors = false;
        }
    }
};
</script>

<style></style>
