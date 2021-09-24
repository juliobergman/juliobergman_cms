<template>
    <v-hover v-slot:default="{ hover }">
        <v-card
            :id="'hover' + media.id"
            tile
            :flat="!hover"
            class="cursor-pointer"
            @click="$emit('click', media.id)"
            color="grey darken-4"
        >
            <v-img
                :contain="contain"
                content-class="thumb"
                v-if="src"
                :src="src"
                :aspect-ratio="aspectRatio"
            >
                <v-row
                    :id="'fill-selector' + media.id"
                    no-gutters
                    class="ma-0 fill-height cursor-pointer d-flex"
                    justify="center"
                    align="start"
                >
                    <v-slide-y-reverse-transition v-if="media.name">
                        <v-card
                            v-if="hover || $isMobile()"
                            color="rgba(0,0,0,0.6)"
                            tile
                            class="mt-auto"
                            width="100%"
                            dark
                        >
                            <v-card-text
                                class="text-overline title--text pb-0 mb-n5"
                                v-text="media.subtitle"
                            />
                            <v-card-text
                                class="card-title"
                                v-text="media.name"
                            />
                        </v-card>
                    </v-slide-y-reverse-transition>
                </v-row>
            </v-img>
        </v-card>
    </v-hover>
</template>

<script>
export default {
    props: {
        contain: { type: Boolean, default: false },
        aspectRatio: { default: 4 / 3 },
        src: {
            type: String,
            default: "/storage/factory/stock/cover-placeholder/xlarge.jpg"
        },
        media: {
            type: Object,
            default() {
                return {
                    id: null,
                    name: null,
                    subtitle: null
                };
            }
        },
        overlay: {
            type: String,
            default: "rgba(0,0,0,0)"
        }
    },
    computed: {},
    mounted() {
        let hoverId = "#fill-selector" + this.media.id;
        let hoverCard = document.getElementById("hover" + this.media.id);
        let duration = 0.3;

        this.gsap.set(hoverId, {
            duration: duration,
            background: this.overlay
        });

        hoverCard.addEventListener("mouseenter", () => {
            this.gsap.to(hoverId, {
                duration: duration,
                background: "rgba(0,0,0,0)"
            });
        });
        hoverCard.addEventListener("mouseleave", () => {
            this.gsap.to(hoverId, {
                duration: duration,
                background: this.overlay
            });
        });
    }
};
</script>

<style scoped>
.card-title {
    font-weight: lighter;
    text-transform: uppercase;
    font-size: calc(0.9rem + (((100vw - 20rem) / (90 - 20))) * (1.5 - 0.9));
    line-height: calc(1.2rem + (((100vw - 20rem) / (90 - 20))) * (2.1 - 1.2));
}
.handle {
    color: white;
}
.thumb:hover {
    background-size: 1.5rem;
}
</style>
