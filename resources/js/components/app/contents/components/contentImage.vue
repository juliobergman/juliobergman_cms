<template>
    <v-hover v-slot:default="{ hover }">
        <v-card flat class="mt-4">
            <v-img :aspect-ratio="ar" :src="src">
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
                    class="fill-height ma-0"
                    align="end"
                    justify="center"
                >
                    <v-slide-y-reverse-transition>
                        <div v-show="hover || $isMobile()" class="mb-2 mb-md-4">
                            <change-image
                                :selected="selected"
                                @select="selected = $event"
                            >
                                <v-icon :small="$isMobile()" class="mr-2">
                                    mdi-camera
                                </v-icon>
                                Change
                            </change-image>
                        </div>
                    </v-slide-y-reverse-transition>
                </v-row>
            </v-img>
        </v-card>
    </v-hover>
</template>

<script>
import ChangeImage from "../../media/component/changeImage.vue";
export default {
    components: {
        ChangeImage
    },
    props: {
        ar: { default: 4 / 3 },
        src: { type: String },
        mediaId: { type: Number, default: null }
    },
    computed: {
        selected: {
            get() {
                return this.mediaId;
            },
            set(val) {
                this.$emit("select", val);
            }
        }
    },
    data: () => ({}),
    methods: {}
};
</script>

<style></style>
