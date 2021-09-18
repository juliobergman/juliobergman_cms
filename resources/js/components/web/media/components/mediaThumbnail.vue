<template>
    <v-hover v-slot:default="{ hover }">
        <v-card
            flat
            class="cursor-pointer"
            @click="$emit('click', media.id)"
            color="grey darken-4"
        >
            <v-img
                content-class="thumb"
                v-if="src"
                :src="src"
                :aspect-ratio="aspectRatio"
            >
                <v-row
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
                                class="text-h5 font-weight-light text--white pa-3 pa-md-6"
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
        aspectRatio: { default: 4 / 3 },
        src: {
            type: String,
            default: "/storage/factory/stock/cover-placeholder.jpg"
        },
        media: {
            type: Object,
            default() {
                return {
                    id: null,
                    name: null
                };
            }
        }
    },
    computed: {
        pubColor() {
            return this.media.public == "yes" ? "primary" : "grey lighten-2";
        },
        pubIcon() {
            return this.media.public == "yes"
                ? "mdi-checkbox-marked"
                : "mdi-checkbox-blank-outline";
        }
    }
};
</script>

<style scoped>
.handle {
    color: white;
}
.thumb:hover {
    background-size: 1.5rem;
}
</style>
