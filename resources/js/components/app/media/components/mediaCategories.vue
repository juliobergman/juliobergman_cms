<template>
    <v-dialog v-model="dialog" scrollable max-width="600">
        <template v-slot:activator="{ on, attrs }">
            <v-btn v-show="!hidden" icon v-bind="attrs" v-on="on">
                <v-icon>
                    mdi-image-multiple-outline
                </v-icon>
            </v-btn>
        </template>

        <v-card :loading="$store.state.loading">
            <v-card-title>
                <v-icon class="mr-2">
                    mdi-image-multiple-outline
                </v-icon>
                Albums
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text class="pt-0 pb-3" v-show="noItems">
                <show-alert class="my-0">
                    <strong>There is no Albums in your Media Gallery</strong>,
                    <br />
                    Create One to start uploading your images.
                </show-alert>
            </v-card-text>
            <v-card-text class="pa-0 red" style="max-height: 50vh">
                <v-list two-line>
                    <v-list-item
                        v-for="category in categories"
                        :key="category.title"
                    >
                        <v-list-item-avatar>
                            <v-icon class="grey lighten-1" dark>
                                mdi-folder-image
                            </v-icon>
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title
                                v-text="category.name"
                            ></v-list-item-title>

                            <v-list-item-subtitle
                                v-if="category.created_at"
                                v-text="category.created_at"
                            ></v-list-item-subtitle>
                        </v-list-item-content>

                        <v-list-item-action>
                            <v-btn icon @click="destroy(category)">
                                <v-icon color="grey lighten-1">
                                    mdi-delete
                                </v-icon>
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn text :disabled="$store.state.loading" @click="close()">
                    Close
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    text
                    :loading="$store.state.loading"
                    @click="$emit('dialog:newcategory', true)"
                >
                    New
                </v-btn>
            </v-card-actions>
        </v-card>
        <alert ref="alert" />
        <confirm ref="confirm" />
    </v-dialog>
</template>

<script>
import showAlert from "../../ui/alert/mod1.vue";
export default {
    components: {
        showAlert
    },
    props: {
        items: Array,
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
        newAnim: "",
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
        categories() {
            return this.items;
        },
        noItems() {
            return this.items.length < 1 ? true : false;
        }
    },
    methods: {
        close() {
            this.dialog = false;
        },
        destroy($item) {
            this.$refs.confirm
                .open(
                    null,
                    [
                        "Are you sure you want to delete" +
                            $item.name +
                            " from your albums?",
                        "Content description and connections with sections also will be deleted.",
                        "This action cannot be undone."
                    ],
                    {
                        color: "danger"
                    }
                )
                .then(confirmResponse => {
                    if (confirmResponse) {
                        this.$store.commit("loading", true);
                        axios
                            .delete("/api/media/category/destroy", {
                                data: $item
                            })
                            .then(response => {
                                this.$refs.alert
                                    .open(null, response.data.messages, {
                                        color: "success"
                                    })
                                    .then(() => {
                                        this.$emit("saved");
                                        if (this.items.length < 2) {
                                            this.close();
                                        }
                                        this.$store.commit("loading", false);
                                    });
                            })
                            .catch(error => {
                                console.error(error.response);
                                if (error.response.status == "405") {
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
    }
};
</script>

<style scoped></style>
