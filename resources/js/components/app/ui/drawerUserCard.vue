<template>
    <v-list-item class="px-2">
        <v-list-item-avatar>
            <v-img :src="$store.state.user.data.profile_pic"> </v-img>
        </v-list-item-avatar>

        <v-list-item-title>
            {{ $store.state.user.data.name }}
        </v-list-item-title>

        <account-menu></account-menu>
    </v-list-item>
</template>

<script>
import AccountMenu from "./accountMenu";
export default {
    components: {
        AccountMenu
    }
};
</script>

<style></style>
