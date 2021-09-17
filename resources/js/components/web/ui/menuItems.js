const gradients = [
    "#0066ff, #000000, #000000, #434343", //Home
    "#a044ff, #6a3093, #000000", //Media
    "#845EC2, #00C9A7, #4D8076, #000000", //Dev
    "#71B280, #add100, #7b920a, #4b6cb7", //Lab
    "#ff512f, #991F52, #000000, #4D0A30", //Contact
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
            duration: 1,
            gradient: gradients[0]
        }
    },
    {
        text: "Media",
        icon: "mdi-camera-iris",
        to: "media",
        hero: {
            height: "30vh",
            duration: 1,
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
            duration: 1,
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
            duration: 1,
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
            duration: 1,
            gradient: gradients[4]
            // gradient: gradients[Math.floor(Math.random() * (max - min)) + min]
        }
    }
];
