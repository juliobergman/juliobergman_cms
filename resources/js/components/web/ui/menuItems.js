const gradients = [
    "rgba(32,118,255,1) 0%, rgba(13,43,90,1) 40%, rgba(0,0,0,1) 100%", //Home
    "rgba(160,68,255,1) 0%, rgba(106,48,147,1) 25%, rgba(0,0,0,1) 75%", //Media
    "rgba(58,255,236,1) 0%, rgba(162,145,247,1) 30%, rgba(0,0,0,1) 100%", //Dev
    "rgba(56,239,125,1) 0%, rgba(17,153,142,1) 30%, rgba(0,0,0,1) 100%", //Lab
    "rgba(245,175,25,1) 0%, rgba(255,0,99,1) 25%, rgba(0,0,0,1) 100%", //Contact
    "#845EC2, #00C9A7, #4D8076, #000000" //Lab
];

let min = 0;
let max = gradients.length;

export const items = [
    {
        text: "Home",
        icon: "mdi-view-dashboard",
        to: "home",
        hero: {
            height: "100vh",
            deg: 15,
            gradient: gradients[0]
        }
    },
    {
        text: "Media",
        icon: "mdi-camera-iris",
        to: "media",
        hero: {
            height: "30vh",
            deg: 10,
            gradient: gradients[1]
            // gradient: gradients[Math.floor(Math.random() * (max - min)) + min]
        }
    },
    {
        text: "Dev",
        icon: "mdi-laptop",
        to: "development",
        hero: {
            height: "30vh",
            deg: 40,
            gradient: gradients[2]
            // gradient: gradients[Math.floor(Math.random() * (max - min)) + min]
        }
    },
    {
        text: "Lab",
        icon: "mdi-flask-outline",
        to: "lab",
        hero: {
            height: "30vh",
            deg: 165,
            gradient: gradients[3]
            // gradient: gradients[Math.floor(Math.random() * (max - min)) + min]
        }
    },
    {
        text: "Contact",
        icon: "mdi-account",
        to: "contact",
        hero: {
            height: "30vh",
            deg: -35,
            gradient: gradients[4]
            // gradient: gradients[Math.floor(Math.random() * (max - min)) + min]
        }
    }
];
