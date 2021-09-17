<template>
    <v-sheet class="hero d-flex justify-center align-end">
        <Particles id="tsparticles" url="/storage/factory/particles.json" />
        <hero-content id="heroContent" :height="height" />
        <div class="process">
            <div class="ma-2">
                {{ mouse }}
            </div>
            <div class="ma-2">
                {{ rotation }}
            </div>
        </div>
    </v-sheet>
</template>

<script>
import { bus } from "../../../app";
import heroContent from "./heroContent.vue";
export default {
    components: { heroContent },
    data: () => ({
        loaded: true,
        height: "100vh",
        hero: 1,
        gradient: undefined,
        rotation: 0,
        mouse: {
            x: null,
            y: null,
            deg: null
        }
    }),
    methods: {
        scroll() {
            console.log("scroll");
        },
        onMouseMove(event) {
            // this.mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            // this.mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
            // this.mouse.deg =
            //     (Math.atan2(this.mouse.y, this.mouse.x) * 180) / Math.PI;
            // let nr = this.mouse.deg;
            // console.log(nr);
            // this.rotation = (nr + 90) * -1;
            // this.gsap.to(".hero", {
            //     duration: 20,
            //     delay: 0.5,
            //     ease: "none",
            //     background:
            //         "linear-gradient(" +
            //         this.rotation +
            //         "deg, " +
            //         this.gradient +
            //         ")"
            // });
        }
    },
    computed: {},
    created() {},
    mounted() {
        // document.addEventListener("mousemove", this.onMouseMove, false);
        bus.$on("hero:height", data => {
            this.hero++;
            this.height = data.height;
            this.gradient = data.gradient;
            let deg = Math.floor(Math.random() * (360 - 0)) + 0;
            this.rotation = 0;
            this.gsap.to(".hero", {
                duration: data.duration,
                height: data.height,
                ease: "power2",
                background:
                    "linear-gradient(" + deg + "deg, " + data.gradient + ")"
            });
        });
    }
};
</script>
<style scoped>
.process {
    display: none;
    position: fixed;
    bottom: 0;
    right: 0;
    background: rgba(250, 247, 247, 0.8);
    padding: 2rem;
    color: white;
    z-index: 10;
}
.hero {
    background: linear-gradient(45deg, #20bdff, #5433ff);
    min-height: 200px;
    /* z-index: 1; */
}
.btn-explore {
    position: absolute;
    z-index: 2;
}
#tsparticles {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
</style>
