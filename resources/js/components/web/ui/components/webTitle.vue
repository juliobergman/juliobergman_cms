<template>
    <v-row class="d-flex flex-column mt-16 mb-12">
        <h1 v-if="title" class="text-center text-h2 titles--text">
            {{ title }}
        </h1>
        <h2
            v-if="subtitle"
            class="text-center text-subtitle-1 subtitles--text mt-10"
        >
            {{ subtitle }}
        </h2>
    </v-row>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: "Default Text"
        },
        subtitle: {
            type: String,
            default: null
        }
    }
};
</script>

<style></style>
