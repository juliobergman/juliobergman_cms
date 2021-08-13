<template>
    <v-menu min-width="160" transition="scale-transition">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon :color="icncolor" v-bind="attrs" v-on="on">
                <v-icon>mdi-account</v-icon>
            </v-btn>
        </template>

        <v-list dense nav>
            <v-list-item
                link
                v-for="item in items"
                :key="item.title"
                @click="goto(item.route)"
            >
                <v-list-item-icon class="mr-4">
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider class="my-2"></v-divider>

            <v-list-item @click="logout()">
                <v-list-item-icon class="mr-4">
                    <v-icon>mdi-logout</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script>
import { bus } from "../../../app";
export default {
    props: ["bus"],
    data: () => ({
        blue: false,
        items: [
            {
                title: "Profile",
                icon: "mdi-account",
                route: "appAccount",
                section: "appAccount"
            }
        ]
    }),
    computed: {
        icncolor() {
            return this.$route.meta.section == "appAccount"
                ? "grey darken-4"
                : "";
        }
    },
    methods: {
        goto(route) {
            bus.$emit("go:to", route);
        },
        logout() {
            axios
                .post("/logout")
                .then(response => {
                    if (response.status == 204) {
                        window.location.replace("/login");
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        // this.$router.afterEach((to, from) => {
        //     this.blue = false;
        // });
    }
};
</script>

<style></style>
