<template>
    <v-container fluid>
        <v-toolbar dense flat v-if="currentSection">
            <menu-select
                v-model="section"
                :items="sections"
                :btnText="currentSection.name"
                @input="getContents()"
            />

            <v-spacer></v-spacer>

            <v-slide-x-reverse-transition>
                <v-btn v-show="$store.state.unsaved" icon @click="saveOrder()">
                    <v-icon>mdi-content-save</v-icon>
                </v-btn>
            </v-slide-x-reverse-transition>

            <new-section @saved="getSections()" />
            <new-connection
                :sections="sections"
                :section="section"
                @saved="getContents()"
                @section="section = $event"
            />
        </v-toolbar>

        <draggable
            v-model="content"
            handle=".handle"
            @change="btnSave = true"
            v-bind="dragOptions"
            @start="drag = true"
            @end="drag = false"
        >
            <transition-group
                type="transition"
                :name="!drag ? 'flip-list' : null"
                tag="div"
                class="row mt-4"
            >
                <v-col
                    cols="6"
                    sm="4"
                    md="3"
                    v-for="(item, idx) in content"
                    :key="item.id"
                >
                    <media-thumbnail
                        sortable
                        :media="item"
                        :src="item.cover_image.medium"
                        @click="show"
                        :aspect-ratio="armedia"
                    />
                </v-col>
            </transition-group>
        </draggable>

        <v-footer padless absolute v-if="pageLength > 1">
            <v-card tile flat width="100%">
                <v-pagination
                    color="primary"
                    v-model="page"
                    :length="pageLength"
                    total-visible="7"
                    class="pagination"
                    @input="getContents"
                ></v-pagination>
            </v-card>
        </v-footer>
        <edit-connection
            v-model="showConnectionDialog"
            :sections="sections"
            :connection="itemConnectionDialog"
            @close="itemConnectionDialog = null"
            @saved="updateContents"
            @edit="showContentDialog = true"
        />

        <content-dialog
            :content-id="itemContentDialog"
            v-model="showContentDialog"
            @saved="updateContents"
        />
        <confirm ref="confirm"></confirm>
        <!-- @update="itemContentDialog = $event" -->
    </v-container>
</template>

<script>
import newSection from "./components/newSection.vue";
import newConnection from "./components/newConnection.vue";
import editConnection from "./components/editConnection.vue";

import draggable from "vuedraggable";
import mediaThumbnail from "../../app/media/components/mediaThumbnail.vue";
import contentDialog from "../contents/components/contentDialog.vue";
import menuSelect from "../ui/menuSelect.vue";
import confirm from "../ui/alert/confirm.vue";
export default {
    components: {
        menuSelect,
        newSection,
        newConnection,
        editConnection,
        draggable,
        mediaThumbnail,
        contentDialog,
        confirm
    },
    data: () => ({
        drag: false,
        page: 1,
        pageLength: 1,
        sections: [],
        section: 1,
        showContentDialog: false,
        showConnectionDialog: false,
        itemConnectionDialog: null,
        content: []
    }),
    computed: {
        dragOptions() {
            return {
                animation: 200,
                group: "description",
                disabled: false,
                ghostClass: "ghost"
            };
        },
        currentSection() {
            return this.sections.find(e => e.id == this.section);
        },
        pageRecords() {
            return this.$isMobile() ? 6 : 12;
        },
        armedia() {
            return this.$isMobile() ? 1 : 4 / 3;
        },
        itemContentDialog() {
            if (!this.itemConnectionDialog) return null;
            return this.itemConnectionDialog.content_id;
        }
    },
    methods: {
        getSections() {
            this.$store.commit("loading", true);
            axios
                .get("/api/sections")
                .then(response => {
                    this.sections = response.data;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.response);
                });
        },
        async getContents() {
            this.$store.commit("loading", true);
            let postData = {
                section: this.section,
                records: this.pageRecords
            };

            return axios
                .post("/api/connections?page=" + this.page, postData)
                .then(response => {
                    this.content = response.data.data;
                    this.pageLength = response.data.last_page;
                    this.$store.commit("loading", false);
                    return Promise.resolve(response.data.data);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.response);
                });
        },
        updateContents(payload) {
            this.$store.commit("loading", true);
            this.getContents()
                .then(contents => {
                    this.$store.commit("loading", true);
                    return contents.find(e => e.content_id == payload);
                })
                .then(conn => {
                    this.itemConnectionDialog = conn;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        show(item) {
            if (this.$store.state.unsaved) {
                this.$refs.confirm
                    .open(
                        "Warning",
                        [
                            "You currently have unsaved changes, Are you sure you want to exit without saving?",
                            "Choose YES to leave without saving any changes."
                        ],
                        {
                            color: "warning",
                            messageAlign: "left",
                            btnCancel: "return",
                            width: 375
                        }
                    )
                    .then(confirmResponse => {
                        if (confirmResponse) {
                            this.$store.commit("unsaved", false);
                            this.itemConnectionDialog = this.content.find(
                                e => e.id == item
                            );
                            this.showConnectionDialog = true;
                        }
                    });
            }
            if (!this.$store.state.unsaved) {
                this.itemConnectionDialog = this.content.find(
                    e => e.id == item
                );
                this.showConnectionDialog = true;
            }
        },
        saveOrder() {
            this.$store.commit("loading", true);
            axios
                .post("/api/connection/update/bulk", this.content)
                .then(response => {
                    this.$store.commit("unsaved", false);
                    this.$store.commit("loading", false);
                })
                .catch(response => {
                    console.error(response.name);
                    console.error(response.message);
                });
        }
    },
    created() {
        this.getSections();
        this.getContents();
    },
    watch: {
        section() {
            this.getContents();
        },
        drag() {
            this.$store.commit("unsaved", true);
        }
    }
};
</script>

<style scoped>
.button {
    margin-top: 35px;
}
.flip-list-move {
    transition: transform 0.5s;
}
.no-move {
    transition: transform 0s;
}
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}
.list-group {
    min-height: 20px;
}
.list-group-item {
    cursor: move;
}
.list-group-item i {
    cursor: pointer;
}

/* Pagination */
.pagination .v-pagination__navigation,
.pagination .v-pagination__item {
    box-shadow: none;
}
</style>
