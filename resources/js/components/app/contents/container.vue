<template>
    <v-container fluid>
        <show-alert
            v-model="noContent"
            btn-text="Create"
            btn-icon="mdi-view-grid-plus"
            @trigger="newContentDialog = true"
        >
            <strong>There is no Content available</strong>,
            <br />
            Create Something!
        </show-alert>
        <v-slide-y-transition leave-absolute mode="out-in">
            <v-data-iterator
                v-show="!noContent"
                :items="content"
                :items-per-page.sync="itemsPerPage"
                :page.sync="page"
                :search="search"
                :sort-by="sortBy"
                :sort-desc="sortDesc"
                hide-default-footer
            >
                <template v-slot:header>
                    <v-toolbar dense flat class="paddless pr-4">
                        <v-text-field
                            v-model="search"
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            clearable
                            flat
                            solo
                            hide-details
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <template v-if="$vuetify.breakpoint.mdAndUp">
                            <v-select
                                v-model="sortBy"
                                label="Sort by"
                                :items="keys"
                                item-text="text"
                                item-value="value"
                                prepend-inner-icon="mdi-sort-variant"
                                class="mr-2"
                                style="width: 0px"
                                flat
                                solo
                                hide-details
                            ></v-select>
                            <v-btn-toggle
                                v-model="sortDesc"
                                mandatory
                                borderless
                                color="transparent"
                                active-class="btn-active"
                                background-color="transparent"
                                class="mr-2"
                            >
                                <v-btn
                                    color="transparent"
                                    active-class="btn-active"
                                    :value="true"
                                >
                                    <v-icon>mdi-sort-descending</v-icon>
                                </v-btn>
                                <v-btn
                                    color="transparent"
                                    active-class="btn-active"
                                    :value="false"
                                >
                                    <v-icon>mdi-sort-ascending</v-icon>
                                </v-btn>
                            </v-btn-toggle>
                        </template>
                        <new-content
                            v-model="newContentDialog"
                            @saved="getContents()"
                        />
                    </v-toolbar>
                </template>

                <template v-slot:default="props">
                    <v-row class="mt-4">
                        <v-col
                            cols="6"
                            sm="4"
                            md="3"
                            v-for="(item, idx) in props.items"
                            :key="item.id"
                        >
                            <media-thumbnail
                                :force-hover="true"
                                :media="item"
                                :src="item.cover_image.medium"
                                @click="show"
                                :aspect-ratio="aspect"
                            />
                        </v-col>
                    </v-row>
                </template>

                <template v-slot:footer>
                    <v-footer
                        :fixed="$isMobile()"
                        :absolute="!$isMobile()"
                        padless
                        v-if="pageCount > 1"
                    >
                        <v-card tile flat width="100%">
                            <v-pagination
                                color="primary"
                                v-model="page"
                                :length="pageCount"
                                :total-visible="7"
                                class="pagination"
                            ></v-pagination>
                        </v-card>
                    </v-footer>
                </template>
            </v-data-iterator>
        </v-slide-y-transition>
        <content-dialog
            :content-id="itemContentDialog"
            v-model="showContentDialog"
            @input="itemContentDialog = null"
            @saved="getContents()"
        />
    </v-container>
</template>

<script>
import newContent from "./components/contentNew.vue";
import mediaThumbnail from "../../app/media/components/mediaThumbnail.vue";
import contentDialog from "./components/contentDialog.vue";
import showAlert from "../ui/alert/mod1.vue";
export default {
    components: {
        newContent,
        mediaThumbnail,
        contentDialog,
        showAlert
    },
    data: () => ({
        content: [],
        noContent: true,
        page: 1,
        search: "",
        sortBy: "name",
        sortDesc: false,
        newContentDialog: false,
        showContentDialog: false,
        itemContentDialog: null,
        keys: [
            { text: "ID", value: "id" },
            { text: "Name", value: "name" },
            { text: "Path", value: "path" },
            { text: "Date", value: "created_at" },
            { text: "Cover", value: "cover" }
        ]
    }),
    computed: {
        aspect() {
            return this.$isMobile() ? 1 : 4 / 3;
        },
        itemsPerPage() {
            return this.$isMobile() ? 6 : 8;
        },
        pageCount() {
            return Math.ceil(this.content.length / this.itemsPerPage);
        }
    },
    methods: {
        rowClass(item) {
            return "cursor-pointer";
        },
        getContents() {
            this.$store.commit("loading", true);
            axios
                .post("/api/content", {})
                .then(response => {
                    this.content = response.data;
                    this.noContent = response.data.length > 0 ? false : true;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    // TODO
                    console.error(error);
                    console.error(error.response);
                });
        },
        show(item) {
            this.itemContentDialog = item;
            this.showContentDialog = true;
        }
    },
    created() {
        this.getContents();
    },
    watch: {}
};
</script>

<style lang="css" scoped>
.paddless >>> .v-toolbar__content {
    padding-left: 0px !important;
    padding-right: 0px !important;
}
.theme--light .v-btn--active >>> .v-btn__content .v-icon {
    color: cornflowerblue !important;
}
.theme--dark .v-btn--active >>> .v-btn__content .v-icon {
    color: red !important;
}

/* Pagination */
.pagination .v-pagination__navigation,
.pagination .v-pagination__item {
    box-shadow: none;
}
</style>
