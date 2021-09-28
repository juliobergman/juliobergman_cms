<template>
    <v-card
        tile
        flat
        :height="height"
        class="hero d-flex justify-center align-end"
    >
        <Particles
            v-if="particles && !cover"
            id="tsparticles"
            url="/storage/factory/particles.json"
        />
        <custom-parallax v-if="cover" :src="cover" />
        <hero-content v-if="!cover" id="heroContent" />

        <v-progress-linear
            :active="$store.state.loading"
            :indeterminate="$store.state.loading"
            absolute
            bottom
            color="deep-purple accent-4"
        ></v-progress-linear>
    </v-card>
</template>

<script>
import { bus } from "../../../app";
import { heroConfig } from "../ui/assets/hero.js";
import heroContent from "./components/heroContent.vue";
import customParallax from "./components/customParallax.vue";
export default {
    components: { heroContent, customParallax },
    data: () => ({
        height: "100vh"
    }),
    methods: {
        setup() {
            if (!this.hero || !this.content) return;
            this.gsap.timeline({}).to(".hero", this.options);
        },
        animateCover() {
            if (!this.cover) return;
        },
        imageLoad(src) {
            console.log("image loaded");
        }
    },
    computed: {
        windowSize() {
            return {
                w: 400,
                y: 400
            };
        },
        content() {
            return this.$store.state.content;
        },
        hero() {
            this.$store.commit("loading", true);
            let ret = heroConfig.find(e => e.folio == this.content.folio);
            if (ret) {
                this.$store.commit("loading", false);
                return heroConfig.find(e => e.folio == this.content.folio);
            }
            if (!ret) {
                this.$store.commit("loading", false);
                return heroConfig.find(e => e.folio == "default");
            }
        },
        options() {
            this.$store.commit("loading", true);
            let hero = this.hero;
            let options = {};

            if (!this.content.cover) {
                options = {
                    duration: 0.5,
                    ease: "power2",
                    height: hero.height,
                    background: hero.background
                };
            }
            if (this.content.cover) {
                options = {
                    duration: 0.5,
                    ease: "power2",
                    height: "70vh"
                };
            }
            this.$store.commit("loading", false);
            return options;
        },
        cover() {
            let contentCover = this.content.cover;

            if (!contentCover) {
                return "";
            }
            if (contentCover) {
                return this.content.cover_image.xlarge;
            }
        },
        lazycover() {
            let contentCover = this.content.cover;

            if (!contentCover) {
                return "";
            }
            if (contentCover) {
                return this.content.cover_image.thumbnail;
            }
        },
        particles() {
            if (this.hero) {
                return this.hero["particles"];
            } else {
                return false;
            }
        }
    },
    created() {},
    mounted() {
        this.gsap.set(".hero", {
            height: "100vh"
        });
    },
    watch: {
        hero() {
            this.setup();
        },
        cover() {
            this.animateCover();
        }
    }
};
</script>
<style scoped>
.process {
    display: none;
    position: fixed;
    bottom: 0;
    right: 0;
    background: rgba(250, 247, 247, 0.8);
    padding: 2rem;
    color: white;
    z-index: 10;
}
.hero {
    background: #000;
    min-height: 1px;
    z-index: 0;
}
.btn-explore {
    position: absolute;
    z-index: 2;
}
#tsparticles {
    position: fixed;
    z-index: -1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
</style>
