<template>
    <v-menu offset-y min-width="375" transition="slide-y-transition">
        <template v-slot:activator="{ on, attrs }">
            <div class="text-button" v-bind="attrs" v-on="on" v-if="btnText">
                {{ btnText }}
            </div>
        </template>

        <v-list dense nav>
            <v-list-item-group v-model="selected">
                <v-list-item
                    link
                    v-for="(item, key) in items"
                    :key="item.id"
                    :value="item[itemValue]"
                    v-show="item[itemValue] != value"
                >
                    <v-list-item-content>
                        <v-list-item-title class="text-button">
                            {{ item[itemText] }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-menu>
</template>

<script>
export default {
    props: {
        value: {},
        items: {},
        itemText: {
            type: String,
            default: "name"
        },
        itemValue: {
            type: String,
            default: "id"
        },
        btnText: {
            type: String,
            default: "Menu"
        }
    },
    model: {
        prop: "value",
        event: "input"
    },
    computed: {
        selected: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit("change");
                this.$emit("input", val);
            }
        }
    }
};
</script>

<style></style>
