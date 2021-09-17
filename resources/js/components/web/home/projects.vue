<template>
    <v-container style="max-width: 1024px" class="mt-5">
        <v-row>
            <v-col
                cols="12"
                sm="6"
                md="6"
                v-for="(item, idx) in contents"
                :key="item.id"
            >
                <media-thumbnail
                    :media="item"
                    :src="item.cover_image.medium"
                    @click="show"
                />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import mediaThumbnail from "../media/components/mediaThumbnail.vue";
export default {
    components: { mediaThumbnail },
    data: () => ({
        contents: null,
        page: 1,
        pageRecords: 12,
        pageLength: 1
    }),
    methods: {
        show(item) {
            console.log(item);
        },
        getContents() {
            this.$store.commit("loading", true);
            let postData = {
                section: 1,
                records: this.pageRecords
            };

            axios
                .post("/api/guest/content?page=" + this.page, postData)
                .then(response => {
                    this.contents = response.data.data;
                    this.pageLength = response.data.last_page;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.response);
                });
        }
    },
    created() {
        this.getContents();
    }
};
</script>

<style></style>
