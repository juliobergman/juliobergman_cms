<template>
    <v-hover v-slot:default="{ hover }">
        <v-card
            flat
            class="cursor-pointer"
            @click="$emit('open', item)"
            color="grey darken-4"
        >
            <v-img
                v-if="item.cover_image"
                :src="item.cover_image.fullsize"
                :aspect-ratio="4 / 3"
            >
                <v-row
                    no-gutters
                    class="ma-0 fill-height cursor-pointer d-flex flex-column"
                >
                    <v-fade-transition>
                        <v-icon
                            dark
                            v-show="hover"
                            class="cursor-grab handle mr-auto mt-2 ml-2"
                        >
                            <!-- mdi-checkbox-blank-circle-outline -->
                            mdi-fit-to-page
                        </v-icon>
                    </v-fade-transition>
                    <v-slide-y-reverse-transition>
                        <v-card
                            v-if="hover || $isMobile()"
                            color="rgba(0,0,0,0.6)"
                            tile
                            class="mt-auto"
                        >
                            <v-card-text
                                class="text-md-subtitle-2 white--text pa-2"
                                v-text="item.name"
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
        item: { type: Object }
    },
    data: () => ({}),
    methods: {}
};
</script>

<style></style>
