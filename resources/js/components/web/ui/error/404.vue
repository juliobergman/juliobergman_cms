<template>
    <v-container>
        <v-card color="transparent" flat max-width="500" class="mx-auto">
            <v-card-text>
                <pt title="Page Not Found" />
            </v-card-text>
            <v-card-text>
                Lorem Ipsum Dolor
            </v-card-text>
            <v-card-actions>
                <v-btn
                    href="https://en.wikipedia.org/wiki/HTTP_404"
                    target="_blank"
                    text
                    >more Info</v-btn
                >
                <v-spacer></v-spacer>
                <v-btn to="/" text>Return to Home Page</v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
import pt from "../components/webTitle.vue";
export default {
    components: { pt },
    data: () => ({}),
    methods: {},
    created() {}
};
</script>

<style></style>
