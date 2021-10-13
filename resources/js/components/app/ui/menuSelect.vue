<template>
    <v-menu
        :disabled="items.length <= 1 ? true : false"
        offset-y
        min-width="375"
        transition="slide-y-transition"
    >
        <template v-slot:activator="{ on, attrs }">
            <div class="text-button" v-bind="attrs" v-on="on">
                {{ text }}
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
        label: {
            type: String,
            default: "Label"
        },
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
        },
        text() {
            let text;
            let data;
            if (this.items.some(e => e.id == this.value)) {
                data = this.items.find(e => e.id == this.value);
                if (data.name) text = data.name;
            } else {
                text = this.btnText;
            }
            return text;
        }
    },
    beforeUpdate() {
        console.log(this.items.length);
    }
};
</script>

<style></style>
