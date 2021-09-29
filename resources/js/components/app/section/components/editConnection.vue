<template>
    <v-dialog
        :fullscreen="$isMobile()"
        v-model="dialog"
        max-width="450"
        @input="close()"
    >
        <v-card :tile="$isMobile()" v-if="conn">
            <v-img :src="conn.cover_image.medium" />

            <v-card-text class="mt-5">
                <v-card outlined>
                    <v-card-text>
                        <div class="text-h6">{{ conn.name }}</div>
                        <div class="text-subtitle-2">{{ conn.subtitle }}</div>
                        <div class="text-subtitle-2">{{ conn.path }}</div>
                    </v-card-text>
                </v-card>
            </v-card-text>

            <v-card-text>
                <v-select
                    v-model="conn.section_id"
                    label="Section"
                    :items="sections"
                    item-text="name"
                    item-value="id"
                    outlined
                    hide-details
                    prepend-inner-icon="mdi-link"
                    @change="$store.commit('unsaved', true)"
                />
            </v-card-text>

            <v-card-text>
                <v-card outlined>
                    <v-card-text class="py-0">
                        <v-switch
                            dense
                            v-model="pub"
                            label="Public"
                            inset
                            class="mx-3"
                            color="primary"
                            @change="$store.commit('unsaved', true)"
                        /> </v-card-text
                ></v-card>
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
                <v-btn :disabled="$store.state.unsaved" text @click="edit()">
                    Edit
                </v-btn>
                <v-btn text @click="save()">
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        value: {
            type: Boolean,
            default: true
        },
        connection: {},
        sections: {}
    },
    data: () => ({
        errors: null,
        conn: null
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
        pub: {
            get() {
                if (!this.conn) return false;
                return this.conn.public == "yes" ? true : false;
            },
            set(val) {
                if (val) {
                    this.conn.public = "yes";
                }
                if (!val) {
                    this.conn.public = "no";
                }
            }
        }
    },
    methods: {
        save() {
            this.$store.commit("loading", true);
            let postData = {
                id: this.conn.id,
                section_id: this.conn.section_id,
                content_id: this.conn.content_id,
                public: this.conn.public
            };

            axios
                .post("/api/connection/update", postData)
                .then(response => {
                    this.close();
                    this.$emit("saved");
                    this.$store.commit("loading", false);
                    this.$store.commit("unsaved", false);
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.$store.commit("loading", false);
                });
        },
        edit() {
            this.$emit("edit", this.conn.content_id);
        },
        close() {
            this.$store.commit("unsaved", false);
            this.errors = null;
            this.$emit("close");
            this.dialog = false;
        }
    },
    watch: {
        connection() {
            this.conn = this.connection;
        }
    }
};
</script>
<style scoped>
.v-text-field--outlined >>> fieldset {
    border-color: rgba(0, 0, 0, 0.12);
}
</style>
