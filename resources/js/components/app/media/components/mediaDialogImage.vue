<template>
    <v-hover v-slot:default="{ hover }">
        <v-card flat>
            <v-img
                class="blackBack"
                :contain="contain"
                :aspect-ratio="aspectRatio"
                :src="src"
                :lazy-src="lazySrc"
                @loadstart="$store.commit('loading', true)"
                @load="$store.commit('loading', false)"
            >
                <template v-slot:placeholder>
                    <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                    >
                        <v-progress-circular
                            indeterminate
                            color="grey lighten-5"
                        ></v-progress-circular>
                    </v-row>
                </template>
                <v-row
                    v-if="$store.state.loading"
                    class="fill-height ma-0"
                    align="center"
                    justify="center"
                >
                    <v-progress-circular
                        indeterminate
                        color="grey lighten-5"
                    ></v-progress-circular>
                </v-row>
                <v-row
                    v-if="!$store.state.loading"
                    class="fill-height ma-0 pb-6"
                    align="end"
                    justify="center"
                >
                    <v-slide-x-reverse-transition v-if="removeBtn">
                        <v-btn
                            v-show="hover || $isMobile()"
                            :small="$isMobile()"
                            icon
                            absolute
                            top
                            right
                            dark
                            @click="$emit('remove')"
                            class="remove-btn"
                            elevation="3"
                        >
                            <v-icon>
                                mdi-delete
                            </v-icon>
                        </v-btn>
                    </v-slide-x-reverse-transition>
                    <v-slide-y-reverse-transition v-if="btnText">
                        <v-btn
                            v-show="hover || $isMobile()"
                            :small="$isMobile()"
                            elevation="2"
                            rounded
                            dark
                            @click="$emit('action', payload)"
                        >
                            <v-icon v-if="btnIcon" class="mr-3">
                                {{ btnIcon }}
                            </v-icon>
                            {{ btnText }}
                        </v-btn>
                    </v-slide-y-reverse-transition>
                </v-row>
            </v-img>
        </v-card>
    </v-hover>
</template>

<script>
export default {
    props: {
        payload: { default: 0 },
        removeBtn: {
            type: Boolean,
            default: false
        },
        aspectRatio: { default: 4 / 3 },
        btnText: {
            type: String,
            default: null
        },
        btnIcon: {
            type: String,
            default: null
        },
        contain: {
            type: Boolean,
            default: false
        },
        src: {
            type: String,
            default: "/storage/factory/stock/cover-placeholder.jpg"
        },
        lazySrc: {
            type: String,
            default: null
        }
    }
};
</script>

<style scoped>
.remove-btn {
    background: #272727;
}
</style>
