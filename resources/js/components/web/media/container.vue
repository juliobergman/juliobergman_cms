<template>
    <v-container>
        <pt title="Media" />
    </v-container>
</template>

<script>
import pt from "../ui/components/webTitle.vue";
export default {
    components: { pt },
    data: () => ({
        media: [],
        page: 1,
        pageRecords: 12,
        pageLength: 1
    }),
    methods: {
        getMedia() {
            this.$store.commit("loading", true);
            let postData = {
                section: 1,
                records: this.pageRecords
            };
            axios
                .post("/api/guest/content?page=" + this.page, postData)
                .then(response => {
                    this.contents = response.data.data;

                    this.contents.forEach(e => {
                        this.ar[e.id] = 4 / 3;
                        // this.ar[e.id] = window.innerWidth / window.innerHeight;
                    });

                    this.pageLength = response.data.last_page;
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    console.error(error);
                    console.error(error.response);
                });
        }
    },
    created() {}
};
</script>

<style></style>
