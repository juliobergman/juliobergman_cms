<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col
                cols="12"
                md="4"
                class="py-md-12 pr-md-8 pl-md-12 mb-3 mb-md-0"
            >
                <v-hover v-slot:default="{ hover }">
                    <v-card flat>
                        <v-img aspect-ratio="1" :src="user.profile_pic">
                            <v-scroll-y-reverse-transition>
                                <v-container
                                    fluid
                                    v-if="hover || (edit && $isMobile())"
                                    class="d-flex mt-auto fill-height"
                                >
                                    <div class="mt-auto mx-auto">
                                        <v-btn
                                            :small="$isMobile()"
                                            elevation="2"
                                            rounded
                                            dark
                                            @click="pickAvatar()"
                                        >
                                            <v-icon
                                                :small="$isMobile()"
                                                class="mr-2"
                                            >
                                                mdi-camera
                                            </v-icon>
                                            Change
                                        </v-btn>
                                    </div>
                                </v-container>
                            </v-scroll-y-reverse-transition>
                        </v-img>
                    </v-card>
                </v-hover>
            </v-col>
            <v-col cols="12" md="8" class="py-md-12 pl-md-8 pr-md-12">
                <v-card flat>
                    <v-card-text>
                        <div class="field-title">
                            <v-text-field
                                v-model="user.name"
                                :readonly="!edit"
                                hide-details
                                :class="tf_class + ' text-h6 text-md-h4 mt-n4'"
                            >
                                <template v-slot:append>
                                    <v-card flat>
                                        <v-img
                                            class="mt-0"
                                            :width="
                                                $isMobile() ? '32px' : '40px'
                                            "
                                            :aspect-ratio="4 / 3"
                                            :src="
                                                '/storage/factory/flags/4x3/' +
                                                    user.country +
                                                    '.svg'
                                            "
                                        />
                                    </v-card>
                                </template>
                            </v-text-field>
                            <div>
                                <v-icon>
                                    mdi-map-marker
                                </v-icon>
                                {{ user.city }},
                                {{ user.country_name }}
                            </div>
                        </div>
                    </v-card-text>
                </v-card>
                <v-card flat class="mt-3">
                    <v-card-text class="d-flex">
                        <span class="subs">
                            Contact Information
                        </span>

                        <v-spacer></v-spacer>
                        <v-scroll-y-transition leave-absolute mode="out-in">
                            <v-btn
                                @click="edit = true"
                                v-show="!edit"
                                small
                                text
                                color="primary"
                            >
                                edit
                            </v-btn>
                        </v-scroll-y-transition>
                        <v-scroll-y-transition leave-absolute mode="out-in">
                            <v-btn
                                @click="save()"
                                v-show="edit"
                                small
                                text
                                color="primary"
                            >
                                save
                            </v-btn>
                        </v-scroll-y-transition>
                    </v-card-text>
                    <v-card-text>
                        <v-scroll-y-transition leave-absolute mode="out-in">
                            <v-text-field
                                v-show="edit || user.address"
                                label="Email"
                                prepend-icon="mdi-email-outline"
                                v-model="user.email"
                                :readonly="!edit"
                                hide-details
                                :class="tf_class"
                            />
                        </v-scroll-y-transition>
                        <v-scroll-y-transition leave-absolute mode="out-in">
                            <v-text-field
                                v-show="edit || user.address"
                                label="Website"
                                prepend-icon="mdi-web"
                                v-model="user.site"
                                :readonly="!edit"
                                hide-details
                                :class="tf_class"
                            />
                        </v-scroll-y-transition>
                        <v-scroll-y-transition leave-absolute mode="out-in">
                            <v-text-field
                                v-show="edit || user.address"
                                label="Phone"
                                prepend-icon="mdi-cellphone"
                                v-model="user.phone"
                                :readonly="!edit"
                                hide-details
                                :class="tf_class"
                            />
                        </v-scroll-y-transition>
                        <v-scroll-y-transition leave-absolute mode="out-in">
                            <v-autocomplete
                                v-show="edit"
                                label="Country"
                                prepend-icon="mdi-earth"
                                v-model="user.country"
                                :items="countries"
                                item-text="name"
                                item-value="iso2"
                                :readonly="!edit"
                                cache-items
                                hide-details
                                :class="tf_class"
                            >
                            </v-autocomplete>
                        </v-scroll-y-transition>
                        <v-scroll-y-transition leave-absolute mode="out-in">
                            <v-text-field
                                v-show="edit"
                                label="City"
                                prepend-icon="mdi-city"
                                v-model="user.city"
                                :readonly="!edit"
                                hide-details
                                :class="tf_class"
                            />
                        </v-scroll-y-transition>
                        <v-scroll-y-transition leave-absolute mode="out-in">
                            <v-textarea
                                v-show="edit || user.address"
                                label="Address"
                                prepend-icon="mdi-map-marker-outline"
                                v-model="user.address"
                                :readonly="!edit"
                                hide-details
                                rows="1"
                                auto-grow
                                :class="tf_class"
                            />
                        </v-scroll-y-transition>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-file-input
            v-show="false"
            id="image"
            name="image"
            ref="image"
            @change="changeAvatar"
        ></v-file-input>
    </v-container>
</template>

<script>
export default {
    components: {},
    data: () => ({
        edit: false,
        countries: [],
        user: {}
    }),
    computed: {
        tf_class() {
            return this.edit
                ? "mb-3 mb-md-7"
                : "mb-3 mb-md-7 text-field-noborder";
        }
    },
    methods: {
        getCountries() {
            axios
                .get("/api/countries")
                .then(response => {
                    this.countries = response.data;
                })
                .catch(error => {
                    // TODO
                    console.error(error);
                    console.error(error.response);
                });
        },
        getUser() {
            axios
                .get("/api/user")
                .then(response => {
                    this.user = response.data;
                    this.getCountries();
                })
                .catch(error => {
                    // TODO
                    console.error(response);
                    console.error(response.message);
                });
        },
        save() {
            this.$store.commit("loading", true);
            axios
                .put("/api/user/update", this.user)
                .then(response => {
                    this.edit = false;
                    this.getUser();
                    this.$store.dispatch("user/setUser");
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    // TODO
                    console.error(error);
                    console.error(error.response);
                });
        },
        pickAvatar() {
            document.getElementById("image").click();
        },
        changeAvatar(e) {
            this.$store.commit("loading", true);
            let formData = new FormData();

            formData.append("image", e);

            let axiosHeaders = {
                headers: {
                    "Content-Type": "multipart/form-data",
                    Accept: "application/json"
                }
            };

            axios
                .post("/api/upload/avatar", formData, axiosHeaders)
                .then(response => {
                    this.$store.dispatch("user/setUser");
                    this.getUser();
                    this.$store.commit("loading", false);
                })
                .catch(error => {
                    // TODO
                    console.error(error);
                    console.error(error.response);
                });
        }
    },
    created() {
        this.getUser();
    }
};
</script>

<style scoped>
.field-title >>> .v-text-field__slot input {
    font-weight: 500;
    min-height: 30px !important;
}
@media (min-width: 960px) {
    .field-title >>> .v-text-field__slot input {
        min-height: 45px !important;
    }
}
.subs {
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
    opacity: 0.5;
}
.text-field-noborder >>> .v-input__slot::before {
    border-style: none !important;
}
</style>
