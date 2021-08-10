import Vue from "vue";
import Vuetify from "vuetify/lib";
import { colors } from "vuetify/lib";

Vue.use(Vuetify);

const opts = {
    theme: {
        dark: false,
        themes: {
            light: {
                appbar: "#4285F4",
                primary: "#4285F4",
                accent: "#00B6FF",
                success: "#5CE537",
                info: "#3ED1F9",
                warning: "#EFB92F",
                danger: "#FF4B30"
            },
            dark: {
                primary: "#0080db",
                accent: "#00B6FF",
                success: "#5CE537",
                info: "#3ED1F9",
                warning: "#EFB92F",
                danger: "#FF4B30"
            }
        }
    }
};

export default new Vuetify(opts);
