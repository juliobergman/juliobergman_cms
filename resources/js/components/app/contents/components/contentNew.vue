<template>
    <v-dialog v-model="dialog" width="500" @input="reset()">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-bind="attrs" v-on="on">
                <v-icon>
                    mdi-view-grid-plus
                </v-icon>
            </v-btn>
        </template>

        <v-card :loading="$store.state.loading">
            <v-card-title>
                New Content
            </v-card-title>

            <v-card-text>
                <v-text-field label="Name" v-model="content.name" />
                <v-text-field label="Page Title" v-model="content.page_title" />
                <v-text-field label="Path" v-model="content.path" />
                <v-text-field label="Folio" v-model="folio" readonly />
                <v-text-field label="SEO Info" v-model="content.seo_info" />
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
    props: {},
    data: () => ({
        dialog: false,
        errors: null,
        content: {
            name: ""
        }
    }),
    computed: {
        folio: {
            get() {
                if (this.content.path) {
                    const splited = this.content.path.split("/");
                    let pos = splited.length - 1;
                    return splited[pos];
                } else {
                    return "";
                }
            },
            set(val) {}
        },
        sendContent() {
            return {
                folio: this.folio,
                name: this.content.name,
                page_title: this.content.page_title,
                path: this.content.path,
                seo_info: this.content.seo_info
            };
        }
    },
    methods: {
        save() {
            this.$store.commit("loading", true);
            this.errors = null;
            axios
                .post("/api/content/store", this.sendContent)
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
            this.content.name = "";
            this.errors = false;
        }
    }
};
</script>

<style></style>
