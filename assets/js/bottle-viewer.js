/**
 * bottle-viewer.js
 *
 * Simple Three.js hero viewer for the Bolly landing page.
 * Loads a .glb model from the page, or displays a fallback bottle when
 * the model cannot be loaded. The viewer supports drag/swipe rotation
 * with OrbitControls and resizes automatically with the page.
 */
import * as THREE from "https://esm.sh/three@0.153.0";
import { OrbitControls } from "https://esm.sh/three@0.153.0/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "https://esm.sh/three@0.153.0/examples/jsm/loaders/GLTFLoader.js";

const DEFAULT_MODEL_URL = "/wp-content/uploads/bolly/models/bolly-bottle.glb";

class BottleViewer {
  constructor(container) {
    this.container = container;
    this.modelUrl = container.dataset.modelUrl || DEFAULT_MODEL_URL;
    this.init();
  }

  init() {
    const w = this.container.clientWidth;
    const h = this.container.clientHeight;
    if (!w || !h) return;

    this.scene = new THREE.Scene();
    this.camera = new THREE.PerspectiveCamera(35, w / h, 0.1, 100);
    this.camera.position.set(0, 0.15, 3.2);

    this.renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    this.renderer.setSize(w, h);
    this.renderer.outputColorSpace = THREE.SRGBColorSpace;
    this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
    this.renderer.toneMappingExposure = 1.1;
    this.container.appendChild(this.renderer.domElement);

    this.addLights();
    this.addControls();
    this.loadModel();
    this.observeResize();
    this.animate();
  }

  addLights() {
    const sky = new THREE.HemisphereLight(0xffffff, 0x3a2c66, 1.1);
    const key = new THREE.DirectionalLight(0xffffff, 1.4);
    key.position.set(2.5, 3, 2);
    const rim = new THREE.DirectionalLight(0xb9a7ff, 1.2);
    rim.position.set(-3, 1.5, -2);
    const fill = new THREE.DirectionalLight(0xffffff, 0.4);
    fill.position.set(0, -2, 2);
    this.scene.add(sky, key, rim, fill);
  }

  addControls() {
    this.controls = new OrbitControls(this.camera, this.renderer.domElement);
    this.controls.enableDamping = true;
    this.controls.dampingFactor = 0.08;
    this.controls.enableZoom = false;
    this.controls.enablePan = false;
    this.controls.minPolarAngle = Math.PI / 3;
    this.controls.maxPolarAngle = Math.PI / 1.7;
    this.controls.autoRotate = true;
    this.controls.autoRotateSpeed = 1.2;
    this.controls.touches = {
      ONE: THREE.TOUCH.ROTATE,
      TWO: THREE.TOUCH.ROTATE,
    };
    this.controls.addEventListener("start", () => {
      this.controls.autoRotate = false;
    });
  }

  loadModel() {
    const loader = new GLTFLoader();
    loader.load(
      this.modelUrl,
      (gltf) => {
        this.model = gltf.scene;
        this.frameModel(this.model);
        this.scene.add(this.model);
        this.container.classList.remove("is-loading");
      },
      null,
      () => {
        this.model = this.createPlaceholder();
        this.scene.add(this.model);
        this.container.classList.remove("is-loading");
        this.container.classList.add("is-placeholder");
      },
    );
  }

  frameModel(model) {
    const bounds = new THREE.Box3().setFromObject(model);
    const size = bounds.getSize(new THREE.Vector3());
    const center = bounds.getCenter(new THREE.Vector3());
    const maxDim = Math.max(size.x, size.y, size.z) || 1;
    const scale = 1.8 / maxDim;
    model.scale.setScalar(scale);
    model.position.sub(center.multiplyScalar(scale));
  }

  createPlaceholder() {
    const group = new THREE.Group();
    const bodyMat = new THREE.MeshPhysicalMaterial({
      color: 0x5b3fe0,
      roughness: 0.35,
      metalness: 0.1,
      clearcoat: 0.4,
      clearcoatRoughness: 0.25,
    });
    const body = new THREE.Mesh(
      new THREE.CylinderGeometry(0.55, 0.6, 1.5, 48),
      bodyMat,
    );
    group.add(body);

    const capMat = new THREE.MeshPhysicalMaterial({
      color: 0xe8e6f5,
      roughness: 0.45,
    });
    const cap = new THREE.Mesh(
      new THREE.CylinderGeometry(0.22, 0.24, 0.35, 32),
      capMat,
    );
    cap.position.y = 0.92;
    group.add(cap);

    const nozzle = new THREE.Mesh(
      new THREE.CylinderGeometry(0.06, 0.06, 0.4, 16),
      capMat,
    );
    nozzle.position.set(0, 1.15, 0.18);
    nozzle.rotation.x = Math.PI / 2.4;
    group.add(nozzle);

    const pumpArm = new THREE.Mesh(
      new THREE.BoxGeometry(0.16, 0.12, 0.5),
      capMat,
    );
    pumpArm.position.set(0, 1.28, 0.05);
    group.add(pumpArm);

    return group;
  }

  observeResize() {
    const observer = new ResizeObserver(() => this.onResize());
    observer.observe(this.container);
  }

  onResize() {
    const w = this.container.clientWidth;
    const h = this.container.clientHeight;
    if (!w || !h) return;
    this.camera.aspect = w / h;
    this.camera.updateProjectionMatrix();
    this.renderer.setSize(w, h);
  }

  animate() {
    requestAnimationFrame(() => this.animate());
    this.controls.update();
    this.renderer.render(this.scene, this.camera);
  }
}

function initBollyViewers() {
  document.querySelectorAll("[data-bolly-viewer]").forEach((el) => {
    if (!el.dataset.bollyViewerInit) {
      el.dataset.bollyViewerInit = "true";
      new BottleViewer(el);
    }
  });
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initBollyViewers);
} else {
  initBollyViewers();
}
