<template>
    <v-container class="mt-5">
        <v-row>
            <v-col cols="12" md="6" v-for="i in 4" :key="i">
                <v-img
                    class="rounded"
                    :aspect-ratio="3 / 2"
                    :src="'storage/factory/' + i + '.jpg'"
                ></v-img>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    components: {},
    data: () => ({}),
    methods: {},
    created() {}
};
</script>

<style></style>
