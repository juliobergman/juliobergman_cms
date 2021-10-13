import Vue from "vue";
import Vuetify from "vuetify/lib";
import { colors } from "vuetify/lib";

Vue.use(Vuetify);

const opts = {
    theme: {
        dark: false,
        themes: {
            light: {
                appbar: "#FFFFFF",
                primary: "#4285F4",
                // primary: "#9C27B0",
                accent: "#00B6FF",
                success: "#5CE537",
                info: "#3ED1F9",
                warning: "#fb8c00",
                danger: "#FF4B30",
                titles: "#666A7E",
                subtitles: "#666A7E",
                body: "#2b3036",
                blackBack: "#121212"
            },
            dark: {
                appbar: "#272727",
                primary: "#4285F4",
                // primary: "#9C27B0",
                accent: "#00B6FF",
                success: "#5CE537",
                info: "#3ED1F9",
                warning: "#EFB92F",
                danger: "#FF4B30",
                titles: "#e4e6f1",
                subtitles: "#ccc",
                body: "#ccc",
                blackBack: "#121212"
            }
        }
    }
};

export default new Vuetify(opts);
