<template>
    <v-dialog
        :fullscreen="$isMobile()"
        v-model="dialog"
        max-width="500"
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
                        /> </v-card-text
                ></v-card>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn text @click="close()">
                    Cancel
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn v-if="false" text @click="edit()">
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
                public: this.conn.public
            };

            axios
                .post("/api/connection/update", postData)
                .then(() => {
                    this.$emit("saved");
                    this.dialog = false;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.message);
                    console.error(error.response);
                });
        },
        edit() {},
        close() {
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
