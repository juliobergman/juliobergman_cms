<template>
    <v-dialog
        v-model="dialog"
        :max-width="options.width"
        :style="{ zIndex: options.zIndex }"
        @keydown.esc="cancel"
    >
        <v-card>
            <v-toolbar v-show="!!title" dense flat>
                <v-toolbar-title
                    :class="options.color + '--text'"
                    v-text="title"
                />
            </v-toolbar>
            <v-card-text
                v-show="!!message"
                :class="'pa-4 text-' + options.messageAlign"
            >
                <div
                    :class="'my-1 font-weight-' + options.fontWeight"
                    v-for="msg in message"
                >
                    {{ msg }}
                </div>
            </v-card-text>
            <v-card-actions class="pt-0">
                <v-spacer></v-spacer>
                <v-btn :color="options.color" text @click.native="accept"
                    >Ok</v-btn
                >
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
        message: [],
        title: null,
        options: {
            messageAlign: "center",
            fontWeight: "medium",
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
            return new Promise(resolve => {
                this.resolve = resolve;
            });
        },
        accept() {
            this.resolve(true);
            this.dialog = false;
        }
    }
};
</script>
