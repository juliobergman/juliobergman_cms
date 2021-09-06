<template>
    <v-dialog fullscreen v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                :small="$isMobile()"
                elevation="2"
                rounded
                dark
                v-bind="attrs"
                v-on="on"
            >
                <slot></slot>
            </v-btn>
        </template>
        <v-card flat tile>
            <v-container fluid fill-height class="align-start">
                <v-row>
                    <v-col
                        cols="6"
                        sm="2"
                        v-for="(item, idx) in $store.state.media.data"
                        :key="item.id"
                    >
                        <v-card
                            flat
                            class="cursor-pointer"
                            @click="sel = item.id"
                        >
                            <v-img :src="item.thumbnail" :aspect-ratio="1 / 1">
                                <v-row
                                    v-if="sel == item.id"
                                    no-gutters
                                    class="fill-height ma-0 justify-center overlay"
                                >
                                    <v-icon large dark>
                                        mdi-check-bold
                                    </v-icon>
                                </v-row>
                            </v-img>
                        </v-card>
                    </v-col>
                </v-row>
                <v-footer padless fixed>
                    <v-card flat tile width="100%">
                        <v-card-actions>
                            <v-btn @click="dialog = false" text>
                                Cancel
                            </v-btn>
                            <v-spacer />
                            <v-btn @click="select()" text>
                                Accept
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-footer>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        selected: { type: Number, default: null }
    },
    computed: {},
    data: () => ({
        dialog: false,
        sel: null
    }),
    methods: {
        select() {
            this.$emit("select", this.sel);
            this.dialog = false;
        }
    },
    created() {
        this.sel = this.selected;
    }
};
</script>

<style></style>
