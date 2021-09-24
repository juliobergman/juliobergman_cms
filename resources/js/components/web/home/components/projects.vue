<template>
    <v-container class="mt-5">
        <v-row>
            <v-col
                cols="12"
                sm="6"
                xl="4"
                v-for="(item, idx) in contents"
                :key="item.id"
            >
                <media-thumbnail
                    :key="item.id"
                    :class="item.folio"
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
            return;

            let selector = "." + content.folio;
            let element = document.getElementsByClassName(content.folio)[0];
            let ar = window.innerWidth / window.innerHeight;
            let rect = element.getBoundingClientRect();
            let rectBody = document.body.getBoundingClientRect();

            let scrollTop =
                window.pageYOffset ||
                document.documentElement.scrollTop ||
                document.body.scrollTop ||
                0;
            let scrollLeft =
                window.pageXOffset ||
                document.documentElement.scrollLeft ||
                document.body.scrollLeft ||
                0;

            let clientTop =
                document.documentElement.clientTop ||
                document.body.clientTop ||
                0;
            let clientLeft =
                document.documentElement.clientLeft ||
                document.body.clientLeft ||
                0;

            let scaleDim = {
                x: window.innerWidth / rect.width,
                y: window.innerHeight / rect.height
            };

            this.ar[content.id] = ar;

            let tween = this.gsap.to(selector, {
                duration: 0.2,
                // scaleX: scaleDim.x,
                // scaleY: scaleDim.y,
                scale: 1.2,
                opacity: 0,
                // y: -rect.y,
                // x: -rect.x,
                // transformOrigin: "top left",
                // zIndex: 3,
                onComplete: () => {
                    // bus.$emit("goto:name", content.folio);
                    // this.$router.push({ name: content.folio });
                }
            });
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
    }
};
</script>

<style></style>
