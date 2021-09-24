const gradients = {
    home: "rgba(32,118,255,1) 0%, rgba(13,43,90,1) 40%, rgba(0,0,0,1) 100%",
    media: "rgba(160,68,255,1) 0%, rgba(106,48,147,1) 25%, rgba(0,0,0,1) 75%",
    dev: "rgba(58,255,236,1) 0%, rgba(162,145,247,1) 30%, rgba(0,0,0,1) 100%",
    lab: "rgba(56,239,125,1) 0%, rgba(17,153,142,1) 30%, rgba(0,0,0,1) 100%",
    contact: "rgba(245,175,25,1) 0%, rgba(255,0,99,1) 25%, rgba(0,0,0,1) 100%",
    last: "#845EC2, #00C9A7, #4D8076, #000000"
};

export const heroConfig = [
    {
        folio: "default",
        particles: true,
        cover: false,
        height: "30vh",
        background: "linear-gradient(" + 15 + "deg, " + gradients.home + ")"
    },
    {
        folio: "home",
        particles: true,
        cover: false,
        height: "100vh",
        background: "linear-gradient(" + 15 + "deg, " + gradients.home + ")"
    },
    {
        folio: "media",
        particles: true,
        cover: false,
        height: "30vh",
        background: "linear-gradient(" + 10 + "deg, " + gradients.media + ")"
    },
    {
        folio: "dev",
        particles: true,
        cover: false,
        height: "30vh",
        background: "linear-gradient(" + 40 + "deg, " + gradients.dev + ")"
    },
    {
        folio: "lab",
        particles: true,
        cover: false,
        height: "30vh",
        background: "linear-gradient(" + 165 + "deg, " + gradients.lab + ")"
    },
    {
        folio: "contact",
        particles: true,
        cover: false,
        height: "30vh",
        background: "linear-gradient(" + -35 + "deg, " + gradients.contact + ")"
    }
];
