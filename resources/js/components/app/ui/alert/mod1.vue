<template>
    <v-slide-y-reverse-transition leave-absolute mode="out-in">
        <v-alert
            v-show="show"
            transition="fade-transition"
            color="blue-grey lighten-3"
            border="left"
            colored-border
            prominent
            :icon="icon"
            class="mt-3"
        >
            <v-row align="center" justify="end">
                <v-col class="grow">
                    <slot />
                </v-col>
                <v-col v-if="btnText" class="shrink">
                    <v-btn
                        depressed
                        dark
                        color="primary
                        darklighten-3"
                        @click="$emit('trigger')"
                        class="ml-auto"
                    >
                        {{ btnText }}
                        <v-icon v-if="btnIcon" class="ml-3">
                            {{ btnIcon }}
                        </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-alert>
    </v-slide-y-reverse-transition>
</template>

<script>
export default {
    props: {
        value: {
            type: Boolean,
            default: false
        },
        btnText: {
            type: String,
            default: ""
        },
        btnIcon: {
            type: String,
            default: ""
        },
        icon: {
            type: String,
            default: "mdi-alert"
        }
    },
    computed: {
        show: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit("input", value);
            }
        }
    },
    methods: {}
};
</script>

<style></style>
