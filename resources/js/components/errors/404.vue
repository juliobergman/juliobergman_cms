<template>
    <v-container>
        <v-card max-width="500" class="mx-auto">
            <v-card-text>
                404
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
export default {
    data: () => ({}),
    methods: {},
    created() {}
};
</script>
