<template>
    <div id="container"></div>
</template>

<script>
import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls";
import { RoomEnvironment } from "three/examples/jsm/environments/RoomEnvironment.js";

import { bus } from "../../../app";

export default {
    name: "ReflectiveMaterial",
    props: {
        height: { default: "250" }
    },
    data() {
        return {
            camera: null,
            scene: null,
            renderer: null,
            mesh: null,
            controls: null
        };
    },
    computed: {
        cheight() {
            return this.height;
        }
    },
    methods: {
        init() {
            let container = document.getElementById("container");

            //   Scene
            this.scene = new THREE.Scene();
            // Camera
            this.camera = new THREE.PerspectiveCamera(
                45,
                container.clientWidth / container.clientHeight,
                1,
                1000
            );
            //   Geometry
            let geometry = new THREE.TorusKnotGeometry(2, 0.95, 200, 16);
            let material = new THREE.MeshStandardMaterial({
                color: 0xffffff,
                metalness: 1,
                roughness: 0.05
            });

            this.mesh = new THREE.Mesh(geometry, material);
            this.mesh.castShadow = true;
            this.scene.add(this.mesh);

            this.mesh.rotation.x += 0;
            this.mesh.rotation.y += 0;
            this.mesh.rotation.z += -0.7;

            // Ground

            const groundGeo = new THREE.PlaneGeometry(50, 50);
            const groundMat = new THREE.ShadowMaterial({
                opacity: 0.2
            });

            const ground = new THREE.Mesh(groundGeo, groundMat);
            ground.position.y = -4.5;
            ground.rotation.x = -Math.PI / 2;
            ground.receiveShadow = true;
            this.scene.add(ground);

            //Lights
            const light = new THREE.DirectionalLight(0xffffff, 1);
            light.position.set(0, 1.75, 0);
            light.position.multiplyScalar(2);
            this.scene.add(light);

            light.castShadow = true;

            light.shadow.mapSize.width = 2048;
            light.shadow.mapSize.height = 2048;

            const d = 20;

            light.shadow.camera.left = -d;
            light.shadow.camera.right = d;
            light.shadow.camera.top = d;
            light.shadow.camera.bottom = -d;

            light.shadow.camera.far = 20;
            light.shadow.bias = -0.0001;

            const lightHelper = new THREE.DirectionalLightHelper(light, 10);
            // this.scene.add(lightHelper);

            // Render
            this.renderer = new THREE.WebGLRenderer({ antialias: true });
            this.renderer.shadowMap.enabled = true;
            // this.renderer.shadowMap.type = THREE.VSMShadowMap;
            this.renderer.setPixelRatio(window.devicePixelRatio);
            this.renderer.setSize(
                container.clientWidth,
                container.clientHeight
            );
            this.renderer.setClearColor(0x121212);

            container.appendChild(this.renderer.domElement);

            //Environment
            let pmremGenerator = new THREE.PMREMGenerator(this.renderer);
            this.scene.environment = pmremGenerator.fromScene(
                new RoomEnvironment(),
                0.04
            ).texture;

            // controls
            this.controls = new OrbitControls(
                this.camera,
                this.renderer.domElement
            );
            this.controls.maxDistance = 30;
            this.controls.minDistance = 15;
            this.camera.position.set(0, 2, 20);
            this.controls.update();
        },
        animate() {
            requestAnimationFrame(this.animate);
            this.mesh.rotation.y += 0.01;
            this.controls.update();
            this.renderer.render(this.scene, this.camera);
        },
        onWindowResize() {
            let container = document.getElementById("container");
            let size = {
                width: container.clientWidth,
                height: container.clientHeight
            };
            this.camera.aspect = size.width / size.height;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(size.width, size.height);
        }
    },
    mounted() {
        this.init();
        this.animate();
        window.addEventListener("resize", this.onWindowResize, false);
        bus.$on("hero:height", payload => {
            this.hero++;
            this.gsap.to("#container", {
                duration: 0.5,
                height: payload,
                ease: "power2"
            });
        });
    }
};
</script>

<style scoped>
#container {
    min-height: 100%;
    height: 100%;
    width: 100%;
}
/* //TODO give your container a size. */
</style>
