<template>
    <v-container
        fluid
        fill-height
        class="content-home pa-0 ma-0 d-flex align-center justify-center"
    >
        <v-row no-gutters class="d-flex flex-column">
            <v-col
                id="anim1"
                class="mx-auto mb-6 mb-sm-8 mb-md-10 mb-lg-12"
                cols="5"
                sm="3"
                md="2"
            >
                <v-card color="transparent" flat class="mx-auto">
                    <v-img contain src="/storage/ui/logo-outline.svg"></v-img>
                </v-card>
            </v-col>
            <v-col id="anim2" class="mx-auto" cols="10" sm="6" md="4">
                <v-card color="transparent" flat class="mx-auto">
                    <v-img
                        contain
                        src="/storage/ui/logo-outline-text.svg"
                    ></v-img>
                </v-card>
            </v-col>
            <v-col id="anim3" class="mx-auto" cols="10" sm="6" md="4" lg="3">
                <v-card
                    v-if="false"
                    color="transparent"
                    dark
                    flat
                    class="mx-auto"
                >
                    <v-card-text
                        class="text-center text-subtitle-1 text-lg-h6 font-weight-light"
                    >
                        Freelancer, Graphic & Web Designer.
                    </v-card-text>
                </v-card>
                <v-card
                    dark
                    flat
                    color="transparent"
                    class="cactions mx-auto mt-6 mt-sm-14"
                >
                    <v-card-actions
                        class="social-buttons d-flex justify-space-around"
                    >
                        <v-btn
                            class="sbtn"
                            icon
                            v-for="item in social"
                            :key="item.name"
                            :href="item.link"
                            target="_blank"
                            link
                        >
                            <v-icon>
                                {{ item.icon }}
                            </v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <div class="btn-explore text-center mb-2 align-self-end">
            <v-card flat color="transparent" dark class="text-button"
                >Scroll</v-card
            >
            <v-btn icon dark @click="scroll()">
                <v-icon>
                    mdi-chevron-down
                </v-icon>
            </v-btn>
        </div>
    </v-container>
</template>

<script>
import { bus } from "../../../../app.js";
export default {
    data: () => ({
        tl: null,
        csection: null,
        social: [
            {
                name: "Behance",
                link: "https://www.behance.net/juliobergman",
                icon: "mdi-behance"
            },
            {
                name: "Dribbble",
                link: "https://dribbble.com/juliobergman",
                icon: "mdi-dribbble"
            },
            {
                name: "Instagram",
                link: "https://www.instagram.com/juliobergman",
                icon: "mdi-instagram"
            },
            {
                name: "Twitter",
                link: "https://www.twitter.com/juliobergmang",
                icon: "mdi-twitter"
            },
            {
                name: "Github",
                link: "https://www.github.com/juliobergman",
                icon: "mdi-github"
            }
        ],
        items: [
            {
                src: "https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg"
            },
            {
                src: "https://cdn.vuetifyjs.com/images/carousel/sky.jpg"
            },
            {
                src: "https://cdn.vuetifyjs.com/images/carousel/bird.jpg"
            },
            {
                src: "https://cdn.vuetifyjs.com/images/carousel/planet.jpg"
            }
        ]
    }),
    methods: {
        scroll() {
            this.gsap.to(window, {
                duration: 0.7,
                scrollTo: { y: ".v-main", offsetY: 64 }
            });
        }
    },
    created() {
        setTimeout(() => {
            bus.$emit("scroll:disable");
        }, 100);
        this.csection = this.$route.name;
    },
    mounted() {
        this.tl = this.gsap
            .timeline({})
            .from("#anim1", {
                duration: 1,
                autoAlpha: 0,
                y: -500,
                scale: 0.01
            })
            .from("#anim2", { duration: 3, autoAlpha: 0 }, 1)
            .from("#anim3", { duration: 0.5, autoAlpha: 0 }, "-=2.5")
            .from(
                ".sbtn",
                {
                    duration: 0.2,
                    scale: 0.01,
                    autoAlpha: 0,
                    stagger: 0.2
                },
                "-=2"
            )
            .from(".btn-explore", {
                duration: 1,
                delay: 1,
                autoAlpha: 0,
                onComplete: () => {
                    bus.$emit("scroll:enable");
                }
            });

        if (this.csection != "home") {
            this.gsap.set(".content-home", {
                autoAlpha: 0,
                scale: 0.01,
                y: "-100vh"
            });
        }

        this.$router.beforeEach((to, from, next) => {
            if (from.name == "home") {
                this.gsap.to(".content-home", {
                    duration: 1,
                    autoAlpha: 0,
                    scale: 0.01,
                    y: "-100vh"
                });
            }
            if (to.name == "home") {
                this.gsap.set(".content-home", {
                    zIndex: 1
                });
                this.gsap.set(".content-home", {
                    duration: 0.5,
                    autoAlpha: 1,
                    scale: 1,
                    y: 0
                });
            }
            next();
        });
    }
};
</script>

<style scoped>
.cactions {
    z-index: 5;
}
.btn-explore {
    position: absolute;
    z-index: 2;
}
</style>
