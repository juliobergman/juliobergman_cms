<template>
    <v-hover v-slot:default="{ hover }">
        <v-card
            flat
            class="cursor-pointer"
            @click="$emit('click', media.id)"
            color="grey darken-4"
        >
            <v-img v-if="src" :src="src" :aspect-ratio="aspectRatio">
                <v-row
                    no-gutters
                    class="ma-0 fill-height cursor-pointer d-flex"
                    justify="center"
                    align="start"
                >
                    <v-fade-transition>
                        <v-icon
                            dark
                            v-show="hover || $isMobile()"
                            class="cursor-grab handle mt-2 ml-2"
                            style="opacity: 0.9"
                        >
                            mdi-fit-to-page
                        </v-icon>
                    </v-fade-transition>
                    <v-spacer></v-spacer>
                    <!-- v-show="hover || $isMobile()" -->
                    <v-fade-transition v-if="media.public">
                        <v-icon
                            :color="pubColor"
                            class="cursor-grab handle mt-2 mr-2"
                            style="opacity: 0.9"
                        >
                            {{ pubIcon }}
                        </v-icon>
                    </v-fade-transition>
                    <v-slide-y-reverse-transition v-if="media.name">
                        <v-card
                            v-if="hover || $isMobile()"
                            color="rgba(0,0,0,0.6)"
                            tile
                            class="mt-auto"
                            width="100%"
                        >
                            <v-card-text
                                class="text-md-subtitle-2 white--text pa-2"
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

<style></style>
