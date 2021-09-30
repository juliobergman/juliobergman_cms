<template>
    <v-dialog v-model="dialog" width="500" @click:outside="close()">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>
                    mdi-view-grid-plus
                </v-icon>
            </v-btn>
        </template>

        <v-card :loading="$store.state.loading">
            <v-card-title>
                Add Content
            </v-card-title>

            <v-card-text class="pa-4">
                <v-select
                    v-model="sec"
                    label="Section"
                    :items="sections"
                    item-text="name"
                    item-value="id"
                    outlined
                    hide-details
                />

                <v-row>
                    <v-icon class="mx-auto my-4">
                        mdi-link
                    </v-icon>
                </v-row>

                <!-- :search-input.sync="search" -->
                <v-autocomplete
                    v-model="content"
                    :items="contentList"
                    :loading="$store.state.loading"
                    label="Content"
                    item-text="name"
                    item-value="id"
                    outlined
                    hide-details
                >
                    <template v-slot:selection="data">
                        <v-chip
                            v-bind="data.attrs"
                            :input-value="data.selected"
                            @click="data.select"
                        >
                            <v-avatar left>
                                <v-img
                                    :src="data.item.cover_image.thumbnail"
                                ></v-img>
                            </v-avatar>
                            {{ data.item.name }}
                        </v-chip>
                    </template>

                    <template v-slot:item="data">
                        <v-list-item-avatar color="primary">
                            <img :src="data.item.cover_image.thumbnail" />
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title
                                v-html="data.item.name"
                            ></v-list-item-title>
                            <v-list-item-subtitle
                                v-html="data.item.subtitle"
                            ></v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-autocomplete>
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
                <v-btn text @click="close()">
                    Cancel
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn text @click="save()">
                    Add
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import axios from "axios";
export default {
    props: {
        sections: Array,
        section: {
            type: Number,
            default: null
        }
    },
    data: () => ({
        dialog: false,
        errors: null,
        content: undefined,
        contentList: []
    }),
    computed: {
        sec: {
            get() {
                return this.section;
            },
            set(val) {
                this.$emit("section", val);
            }
        }
    },
    methods: {
        getContents() {
            this.$store.commit("loading", true);
            axios
                .post("/api/content")
                .then(response => {
                    this.contentList = response.data;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.message);
                    this.$store.commit("loading", false);
                });
        },
        save() {
            this.$store.commit("loading", true);
            this.errors = null;

            let postData = {
                section_id: this.sec,
                content_id: this.content
            };

            axios
                .post("/api/connection/store", postData)
                .then(response => {
                    this.$emit("saved");
                    this.dialog = false;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.$store.commit("loading", false);
                });
        },
        close() {
            this.dialog = false;
            this.content = undefined;
            this.errors = false;
        }
    },
    created() {
        this.getContents();
    }
};
</script>

<style></style>
