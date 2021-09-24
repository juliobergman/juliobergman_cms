<template>
    <div
        :class="'parallax pt-16 d-flex justify-' + justify + ' align-' + align"
        :style="'background-image:url(' + src + ')'"
    >
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        src: {
            type: String
        },
        align: {
            type: String,
            default: "center"
        },
        justify: {
            type: String,
            default: "center"
        }
    },
    mounted() {
        this.gsap.timeline({}).to(".parallax", {
            // backgroundPosition: "top -500px center",
            backgroundPosition: `top ${-window.innerHeight}px center`,
            // backgroundPosition: `top -100% center`,
            ease: "none",
            scrollTrigger: {
                trigger: "#application",
                scrub: true,
                start: "top center",
                end: "bottom center"
                // markers: true
            }
        });
    }
};
</script>
<style scoped>
.parallax {
    background-attachment: fixed;
    background-size: auto 120vh;
    width: 100%;
    height: 100%;
}
</style>
