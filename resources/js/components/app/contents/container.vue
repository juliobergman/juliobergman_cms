<template>
    <v-container fluid>
        <v-toolbar class="red" dense flat>
            <v-tabs color="grey darken-3" v-model="tab_section">
                <v-tab
                    v-for="(tab, idx) in tabs"
                    :key="tab.id"
                    :href="'#tab-' + tab.id"
                    :value="tab.id"
                    v-text="tab.name"
                />
            </v-tabs>
            <v-btn>
                asd
            </v-btn>
        </v-toolbar>
        <v-tabs-items v-model="tab_section">
            <v-tab-item
                v-for="(tab, idx) in tabs"
                :key="tab.id"
                :value="'tab-' + tab.id"
            >
                <draggable
                    v-model="content"
                    handle=".handle"
                    @change="btnSave = true"
                >
                    <transition-group tag="div" class="row mt-4">
                        <v-col
                            v-if="item.section_id == section"
                            cols="12"
                            sm="3"
                            v-for="(item, idx) in content"
                            :key="item.id"
                        >
                            <content-thumbnail :item="item" @open="show" />
                        </v-col>
                    </transition-group>
                </draggable>
            </v-tab-item>
        </v-tabs-items>
        <content-dialog
            v-model="showContentDialog"
            :content="itemContentDialog"
            :sections="tabs"
            @update="itemContentDialog = $event"
            @saved="getContents()"
        />
    </v-container>
</template>

<script>
import draggable from "vuedraggable";
import contentThumbnail from "./components/contentThumb.vue";
import contentDialog from "./components/contentDialog.vue";
export default {
    components: { draggable, contentThumbnail, contentDialog },
    data: () => ({
        tabs: [],
        tab_section: "tab-1",
        showContentDialog: false,
        itemContentDialog: {},
        content: []
    }),
    computed: {
        section() {
            let split = this.tab_section.split("-");
            return split[1];
        }
    },
    methods: {
        getSections() {
            this.$store.commit("loading", true);
            axios
                .get("/api/sections")
                .then(response => {
                    this.tabs = response.data;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.response);
                });
        },
        getContents() {
            this.$store.commit("loading", true);
            axios
                .post("/api/connections", { section: this.section })
                .then(response => {
                    response.data.forEach(e => {
                        if (!e.cover) {
                            e.cover_image = [];
                            e.cover_image.fullsize =
                                "/storage/factory/stock/cover-placeholder.jpg";
                        }
                        if (!e.og_img) {
                            e.og_image = [];
                            e.og_image.fullsize =
                                "/storage/factory/stock/cover-placeholder.jpg";
                        }
                    });

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
        this.getSections();
        this.getContents();
    }
};
</script>

<style></style>
