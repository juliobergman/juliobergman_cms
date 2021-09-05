<template>
    <v-dialog
        v-model="dialog"
        :max-width="options.width"
        :style="{ zIndex: options.zIndex }"
        @keydown.esc="cancel"
    >
        <v-card>
            <v-toolbar v-show="!!title" dense flat>
                <v-toolbar-title :class="options.color + '--text'">{{
                    title
                }}</v-toolbar-title>
            </v-toolbar>
            <v-card-text
                v-show="!!message"
                :class="'pa-4 text-' + options.messageAlign"
                v-text="message"
            />
            <v-card-actions class="pt-0">
                <v-btn
                    v-text="options.btnCancel"
                    color="grey"
                    text
                    @click.native="cancel"
                />
                <v-spacer></v-spacer>
                <v-btn
                    v-text="options.btnAgree"
                    :color="options.color + ' darken-1'"
                    text
                    @click.native="agree"
                />
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        resolve: null,
        reject: null,
        message: null,
        title: null,
        options: {
            messageAlign: "center",
            btnAgree: "Yes",
            btnCancel: "No",
            color: "primary",
            width: 290,
            zIndex: 20
        }
    }),
    methods: {
        open(title, message, options) {
            this.dialog = true;
            this.title = title;
            this.message = message;
            this.options = Object.assign(this.options, options);
            return new Promise((resolve, reject) => {
                this.resolve = resolve;
                this.reject = reject;
            });
        },
        agree() {
            this.resolve(true);
            this.dialog = false;
        },
        cancel() {
            this.resolve(false);
            this.dialog = false;
        }
    }
};
</script>
