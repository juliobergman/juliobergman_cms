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
                    class="ma-0 fill-height cursor-pointer d-flex flex-column"
                >
                    <v-fade-transition>
                        <v-icon
                            dark
                            v-show="hover || $isMobile()"
                            class="cursor-grab handle mb-auto mr-auto mt-2 ml-2"
                            style="opacity: 0.9"
                        >
                            mdi-fit-to-page
                        </v-icon>
                    </v-fade-transition>
                    <v-slide-y-reverse-transition v-if="media.name">
                        <v-card
                            v-if="hover || $isMobile()"
                            color="rgba(0,0,0,0.6)"
                            tile
                            class="mt-auto"
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
    }
};
</script>

<style></style>
