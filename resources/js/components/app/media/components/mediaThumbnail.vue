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
                @loadstart="loading = true"
                @load="loading = false"
            >
                <v-row
                    v-if="loading"
                    class="fill-height ma-0"
                    align="center"
                    justify="center"
                >
                    <v-progress-circular
                        indeterminate
                        color="grey lighten-5"
                    ></v-progress-circular>
                </v-row>
                <v-fade-transition>
                    <div v-show="selected" class="fill-height">
                        <v-row
                            no-gutters
                            class="ma-0 fill-height cursor-pointer d-flex overlay"
                            justify="center"
                            align="center"
                        >
                            <v-icon dark large>
                                mdi-check-bold
                            </v-icon>
                        </v-row>
                    </div>
                </v-fade-transition>
                <v-fade-transition>
                    <div v-show="!selected" class="fill-height">
                        <v-row
                            no-gutters
                            class="ma-0 fill-height cursor-pointer d-flex"
                            absolute
                            justify="center"
                            align="start"
                        >
                            <v-fade-transition v-if="sortable">
                                <v-icon
                                    v-show="hover || $isMobile() || forceHover"
                                    class="cursor-grab handle mt-2 ml-2"
                                >
                                    mdi-dots-grid
                                </v-icon>
                            </v-fade-transition>
                            <v-spacer></v-spacer>
                            <v-fade-transition v-if="media.public">
                                <v-icon
                                    v-if="
                                        hover ||
                                            media.public == 'yes' ||
                                            forceHover
                                    "
                                    small
                                    :color="pubColor"
                                    class="mt-2 mr-2"
                                    style="opacity: 0.9"
                                >
                                    {{ pubIcon }}
                                </v-icon>
                            </v-fade-transition>
                            <v-slide-y-reverse-transition v-if="media.name">
                                <v-card
                                    v-if="hover || $isMobile() || forceHover"
                                    color="rgba(0,0,0,0.6)"
                                    tile
                                    class="mt-auto"
                                    width="100%"
                                >
                                    <v-card-text
                                        v-if="!$isMobile()"
                                        style="opacity: 0.9"
                                        class="white--text pa-2 mb-n3"
                                        v-text="media.subtitle"
                                    />
                                    <v-card-text
                                        class="text-subtitle-2 text-uppercase white--text pa-2"
                                        v-text="media.name"
                                    />
                                </v-card>
                            </v-slide-y-reverse-transition>
                        </v-row>
                    </div>
                </v-fade-transition>
            </v-img>
        </v-card>
    </v-hover>
</template>

<script>
export default {
    props: {
        selected: {
            type: Boolean,
            default: false
        },
        sortable: {
            type: Boolean,
            default: false
        },
        forceHover: {
            type: Boolean,
            default: false
        },
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
    data: () => ({
        loading: false
    }),
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
