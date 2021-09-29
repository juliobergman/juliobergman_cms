<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <v-toolbar-title class="text-button">
                Contents
            </v-toolbar-title>
            <v-text-field
                v-if="false"
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
                solo
                flat
                clearable
                dense
                outlined
            ></v-text-field>
            <v-spacer></v-spacer>
            <new-content @saved="getContents()" />
        </v-toolbar>

        <v-data-table
            :search="search"
            :headers="headers"
            :items="content"
            :items-per-page="itemsPerPage"
            :page.sync="page"
            hide-default-footer
            @click:row="show"
            :item-class="rowClass"
            @page-count="pageCount = $event"
        >
            <template v-slot:item.cover="{ item }">
                <v-card flat width="100px" height="100px" class="my-3 pa-0">
                    <img
                        width="100%"
                        height="100%"
                        :src="item.cover_image.thumbnail"
                        class="ma-0"
                    />
                </v-card>
            </template>
        </v-data-table>

        <v-footer padless absolute v-if="pageCount > 1">
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

        <content-dialog
            :content-id="itemContentDialog"
            v-model="showContentDialog"
            @input="itemContentDialog = null"
            @saved="getContents()"
        />
        <confirm ref="confirm"></confirm>
        <!-- @update="itemContentDialog = $event" -->
    </v-container>
</template>

<script>
import newContent from "./components/contentNew.vue";
import draggable from "vuedraggable";
import mediaThumbnail from "../../app/media/components/mediaThumbnail.vue";
import contentDialog from "./components/contentDialog.vue";
import confirm from "../ui/alert/confirm.vue";
export default {
    components: {
        newContent,
        draggable,
        mediaThumbnail,
        contentDialog,
        confirm
    },
    data: () => ({
        showContentDialog: false,
        itemContentDialog: null,
        search: "",
        page: 1,
        pageCount: 0,
        itemsPerPage: 5,
        content: [],
        headers: [
            { text: "Cover", value: "cover", align: "center", width: "100px" },
            {
                text: "Title",
                value: "name"
            },
            { text: "Path", value: "path" },
            { text: "Page Title", value: "page_title" }
        ]
    }),
    computed: {},
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
            this.itemContentDialog = item.id;
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
