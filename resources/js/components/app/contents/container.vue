<template>
    <v-container fluid>
        <v-data-iterator
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
                            color="primary"
                            background-color="transparent"
                            class="mr-2"
                        >
                            <v-btn
                                icon
                                color="transparent"
                                active-class="primary--text"
                                :value="true"
                            >
                                <v-icon>mdi-sort-descending</v-icon>
                            </v-btn>
                            <v-btn
                                icon
                                color="transparent"
                                active-class="primary--text"
                                :value="false"
                            >
                                <v-icon>mdi-sort-ascending</v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </template>
                    <new-content @saved="getContents()" />
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
import confirm from "../ui/alert/confirm.vue";
export default {
    components: {
        newContent,
        mediaThumbnail,
        contentDialog,
        confirm
    },
    data: () => ({
        content: [],
        page: 1,
        search: "",
        sortBy: "name",
        sortDesc: false,
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
                    this.$store.commit("loading", false);
                })
                .catch(error => {
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

<style scoped>
.paddless >>> .v-toolbar__content {
    padding-left: 0px !important;
    padding-right: 0px !important;
}
.button {
    margin-top: 35px;
}

/* Toggles */
/* .toggle::before {
    color: violet;
}

.toggle-selected::before {
    color: tomato;
} */

/* Pagination */
.pagination .v-pagination__navigation,
.pagination .v-pagination__item {
    box-shadow: none;
}
</style>
