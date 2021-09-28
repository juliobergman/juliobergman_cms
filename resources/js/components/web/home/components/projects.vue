<template>
    <v-container class="projects mt-5">
        <v-row>
            <v-col
                cols="12"
                sm="6"
                xl="4"
                v-for="(item, idx) in contents"
                :key="item.id"
            >
                <media-thumbnail
                    class="thumbs"
                    :key="item.id"
                    :media="item"
                    :src="item.cover_image.large"
                    :overlay="$isMobile() ? null : 'rgba(0,0,0,0.3)'"
                    :aspectRatio="4 / 3"
                    @click="show"
                />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { bus } from "../../../../app";
import mediaThumbnail from "../../media/components/mediaThumbnail.vue";

export default {
    components: { mediaThumbnail },
    data: () => ({
        contents: null,
        ar: [],
        page: 1,
        pageRecords: 12,
        pageLength: 1
    }),
    methods: {
        show(item) {
            let content = this.contents.find(e => e.id == item);
            bus.$emit("goto:name", content.folio);
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
    created() {
        this.getContents();
    },
    updated() {
        this.gsap.utils.toArray(".thumbs").forEach(target => {
            this.gsap.from(target, {
                delay: 0.2,
                duration: 0.5,
                autoAlpha: 0,
                scrollTrigger: {
                    trigger: target,
                    start: "top bottom"
                }
            });
        });
    }
};
</script>

<style></style>
