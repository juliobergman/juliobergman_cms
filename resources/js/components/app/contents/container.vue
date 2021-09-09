<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <menu-select
                v-model="section"
                :items="sections"
                :btnText="sections[section - 1]['name']"
            />

            <v-spacer></v-spacer>

            <new-section @saved="getSections()" />

            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>
                            mdi-view-grid-plus
                        </v-icon>
                    </v-btn>
                </template>
                <span>New Content</span>
            </v-tooltip>
        </v-toolbar>

        <draggable v-model="content" handle=".handle" @change="btnSave = true">
            <transition-group tag="div" class="row mt-4">
                <v-col
                    v-if="item.section_id == section"
                    cols="12"
                    sm="3"
                    v-for="(item, idx) in content"
                    :key="item.id"
                >
                    <media-thumbnail
                        :media="item"
                        :src="item.cover_image.medium"
                        @click="show"
                    />
                </v-col>
            </transition-group>
        </draggable>

        <content-dialog
            v-model="showContentDialog"
            :content="itemContentDialog"
            :sections="tabs"
            @saved="getContents()"
        />
        <!-- @update="itemContentDialog = $event" -->
    </v-container>
</template>

<script>
import newSection from "./components/contentNewSection.vue";

import draggable from "vuedraggable";
import mediaThumbnail from "../../app/media/components/mediaThumbnail.vue";
import contentDialog from "./components/contentDialog.vue";
import menuSelect from "../ui/menuSelect.vue";
export default {
    components: {
        menuSelect,
        newSection,
        draggable,
        mediaThumbnail,
        contentDialog
    },
    data: () => ({
        tabs: [],
        tab_section: "tab-1",
        sections: [],
        section: 1,
        showContentDialog: false,
        itemContentDialog: {},
        content: []
    }),
    computed: {
        // section() {
        //     let split = this.tab_section.split("-");
        //     return split[1];
        // }
    },
    methods: {
        getSections() {
            this.$store.commit("loading", true);
            axios
                .get("/api/sections")
                .then(response => {
                    this.tabs = response.data;
                    this.sections = response.data;
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
                    this.content = response.data;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.response);
                });
        },
        show(item) {
            this.itemContentDialog = this.content.find(e => e.id == item);
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
