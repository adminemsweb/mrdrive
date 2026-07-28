import * as THREE from './three.module.min.js?v=0.185.1';

const host = document.querySelector('[data-product-model]');

if (host) {
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(32, 1, 0.1, 100);
  camera.position.set(0, 0.15, 8.2);

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.12;
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;
  renderer.domElement.setAttribute('aria-label', 'Modelo tridimensional interativo do inversor MRD700/IP65');
  host.prepend(renderer.domElement);

  const model = new THREE.Group();
  model.rotation.set(-0.12, -0.42, 0);
  model.position.y = -0.08;
  model.scale.setScalar(0.92);
  scene.add(model);

  const makeMaterial = (color, roughness = 0.48, metalness = 0.22) =>
    new THREE.MeshStandardMaterial({ color, roughness, metalness });

  const materials = {
    shell: makeMaterial(0x252a30, 0.38, 0.34),
    shellDark: makeMaterial(0x15191e, 0.44, 0.28),
    panel: makeMaterial(0x080b0f, 0.3, 0.32),
    inset: makeMaterial(0x05080b, 0.28, 0.2),
    edge: makeMaterial(0x3b4249, 0.34, 0.42),
    green: makeMaterial(0x46b879, 0.4, 0.08),
    orange: makeMaterial(0xff5b24, 0.34, 0.08),
    cyan: makeMaterial(0x22c8c8, 0.34, 0.08),
    white: makeMaterial(0xe9eef2, 0.5, 0.02),
    yellow: makeMaterial(0xffcf32, 0.4, 0.03),
  };

  const addBox = (name, size, position, material, parent = model) => {
    const mesh = new THREE.Mesh(new THREE.BoxGeometry(...size), material);
    mesh.name = name;
    mesh.position.set(...position);
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    parent.add(mesh);
    return mesh;
  };

  const body = addBox('Gabinete principal', [2.45, 4.15, 1.22], [0, 0, 0], materials.shell);
  const bodyEdges = new THREE.LineSegments(
    new THREE.EdgesGeometry(body.geometry, 28),
    new THREE.LineBasicMaterial({ color: 0x59616a, transparent: true, opacity: 0.38 }),
  );
  body.add(bodyEdges);

  addBox('Lateral esquerda', [0.2, 3.92, 1.3], [-1.19, -0.04, 0], materials.edge);
  addBox('Base frontal', [2.06, 1.72, 0.12], [0, -1.04, 0.68], materials.shellDark);
  addBox('Painel frontal', [1.58, 1.42, 0.15], [0, 0.9, 0.7], materials.panel);
  addBox('Moldura painel', [1.78, 1.62, 0.08], [0, 0.9, 0.64], materials.edge);

  addBox('Display superior', [1.1, 0.27, 0.045], [0, 1.25, 0.795], materials.inset);
  addBox('Display inferior', [1.1, 0.27, 0.045], [0, 0.91, 0.795], materials.inset);

  const displaySurfaces = [1.27, 0.93].map((displayY, row) => {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 112;
    const context = canvas.getContext('2d');
    const texture = new THREE.CanvasTexture(canvas);
    texture.colorSpace = THREE.SRGBColorSpace;
    const screen = new THREE.Mesh(
      new THREE.PlaneGeometry(1.06, 0.22),
      new THREE.MeshBasicMaterial({ map: texture, toneMapped: false }),
    );
    screen.name = row === 0 ? 'Display animado superior' : 'Display animado inferior';
    screen.position.set(0, displayY, 0.828);
    model.add(screen);
    return { canvas, context, texture };
  });

  const displayFrames = [
    ['MRD-700', 'PRONTO'],
    ['MRDRIVES', 'CONTROLE'],
    ['ADQUIRA', 'AGORA'],
  ];
  let lastDisplayState = '';

  const updateDisplays = (elapsed) => {
    const frameDuration = 1.8;
    const frameIndex = Math.floor(elapsed / frameDuration) % displayFrames.length;
    const frameElapsed = elapsed % frameDuration;
    const messages = displayFrames[frameIndex];
    const visibleCharacters = Math.floor(frameElapsed / 0.09) + 1;
    const pulse = 0.78 + Math.sin(elapsed * 5.5) * 0.16;
    const displayState = `${frameIndex}-${visibleCharacters}-${Math.round(pulse * 10)}`;
    if (displayState === lastDisplayState) return;
    lastDisplayState = displayState;

    displaySurfaces.forEach(({ canvas, context, texture }, row) => {
      const message = messages[row].slice(0, visibleCharacters);
      const gradient = context.createLinearGradient(0, 0, 0, canvas.height);
      gradient.addColorStop(0, '#090202');
      gradient.addColorStop(0.5, '#180202');
      gradient.addColorStop(1, '#050000');
      context.fillStyle = gradient;
      context.fillRect(0, 0, canvas.width, canvas.height);
      context.strokeStyle = 'rgba(255, 50, 38, 0.2)';
      context.lineWidth = 3;
      context.strokeRect(2, 2, canvas.width - 4, canvas.height - 4);
      context.textAlign = 'center';
      context.textBaseline = 'middle';
      context.font = '700 62px monospace';
      context.shadowColor = '#ff1f16';
      context.shadowBlur = 18;
      context.fillStyle = `rgba(255, 54, 38, ${pulse})`;
      context.fillText(message, canvas.width / 2, canvas.height / 2 + 3);
      texture.needsUpdate = true;
    });
  };

  const knob = new THREE.Mesh(new THREE.CylinderGeometry(0.27, 0.27, 0.18, 24), materials.edge);
  knob.name = 'Botão de ajuste';
  knob.rotation.x = Math.PI / 2;
  knob.position.set(0, 0.48, 0.84);
  knob.castShadow = true;
  model.add(knob);

  for (let blade = 0; blade < 10; blade += 1) {
    const ridge = addBox('Ranhura do botão', [0.025, 0.21, 0.025], [0, 0, 0], materials.shellDark, knob);
    ridge.rotation.z = (blade / 10) * Math.PI * 2;
    ridge.position.x = Math.sin(ridge.rotation.z) * 0.14;
    ridge.position.z = Math.cos(ridge.rotation.z) * 0.14;
  }

  addBox('Tecla programa', [0.38, 0.22, 0.1], [-0.49, 0.48, 0.82], materials.edge);
  addBox('Tecla função', [0.38, 0.22, 0.1], [0.49, 0.48, 0.82], materials.edge);
  addBox('Tecla RUN', [0.47, 0.25, 0.11], [-0.48, 0.07, 0.83], materials.cyan);
  addBox('Tecla avançar', [0.28, 0.25, 0.11], [0, 0.07, 0.83], materials.edge);
  addBox('Tecla STOP', [0.47, 0.25, 0.11], [0.48, 0.07, 0.83], materials.orange);

  const logoCanvas = document.createElement('canvas');
  logoCanvas.width = 512;
  logoCanvas.height = 160;
  const logoContext = logoCanvas.getContext('2d');
  logoContext.fillStyle = '#eef2f4';
  logoContext.fillRect(0, 0, logoCanvas.width, logoCanvas.height);
  logoContext.textAlign = 'center';
  logoContext.font = '900 58px Arial';
  logoContext.fillStyle = '#0a4f91';
  logoContext.fillText('MR', 210, 70);
  logoContext.fillStyle = '#ff5b24';
  logoContext.fillText('DRIVES', 290, 128);
  const logoTexture = new THREE.CanvasTexture(logoCanvas);
  logoTexture.colorSpace = THREE.SRGBColorSpace;
  const logo = new THREE.Mesh(
    new THREE.PlaneGeometry(1.2, 0.38),
    new THREE.MeshBasicMaterial({ map: logoTexture }),
  );
  logo.name = 'Logotipo MRDRIVES';
  logo.position.set(0, -0.4, 0.755);
  model.add(logo);

  const sideModule = addBox('Módulo lateral', [0.84, 2.66, 1.02], [1.55, 0.48, -0.02], materials.shellDark);
  const sideEdges = new THREE.LineSegments(
    new THREE.EdgesGeometry(sideModule.geometry),
    new THREE.LineBasicMaterial({ color: 0x47515b, transparent: true, opacity: 0.5 }),
  );
  sideModule.add(sideEdges);

  addBox('Módulo lateral chanfrado', [0.92, 1.05, 0.93], [1.52, 1.23, 0.03], materials.edge);

  for (let blockIndex = 0; blockIndex < 2; blockIndex += 1) {
    const terminalY = 0.78 - blockIndex * 0.72;
    const terminal = addBox('Borne verde', [0.23, 0.6, 0.16], [1.1, terminalY, 0.58], materials.green);
    for (let hole = 0; hole < 6; hole += 1) {
      addBox('Entrada do borne', [0.12, 0.055, 0.025], [0, -0.23 + hole * 0.092, 0.09], materials.inset, terminal);
    }
  }

  for (let vent = 0; vent < 8; vent += 1) {
    addBox('Ventilação frontal', [0.055, 0.72, 0.035], [-0.74 + vent * 0.21, -1.38, 0.755], materials.inset);
  }

  for (let vent = 0; vent < 6; vent += 1) {
    addBox('Ventilação lateral', [0.04, 0.42, 0.48], [1.985, 0.84 - vent * 0.18, -0.02], materials.inset);
  }

  addBox('Suporte superior', [2.5, 0.2, 0.26], [0, 2.23, -0.34], materials.edge);
  addBox('Aba suporte esquerda', [0.25, 0.42, 0.22], [-0.96, 2.34, -0.34], materials.edge);
  addBox('Aba suporte direita', [0.25, 0.42, 0.22], [0.96, 2.34, -0.34], materials.edge);

  for (const x of [-0.28, 0.28]) {
    const warning = new THREE.Mesh(new THREE.CircleGeometry(0.13, 3), materials.yellow);
    warning.position.set(x, -1.78, 0.755);
    warning.rotation.z = Math.PI;
    model.add(warning);
  }

  const floor = new THREE.Mesh(
    new THREE.CircleGeometry(2.35, 48),
    new THREE.ShadowMaterial({ color: 0x000000, opacity: 0.32 }),
  );
  floor.rotation.x = -Math.PI / 2;
  floor.position.y = -2.23;
  floor.receiveShadow = true;
  scene.add(floor);

  scene.add(new THREE.HemisphereLight(0xddeeff, 0x07111f, 2.5));

  const keyLight = new THREE.DirectionalLight(0xffffff, 4.4);
  keyLight.position.set(4, 6, 6);
  keyLight.castShadow = true;
  keyLight.shadow.mapSize.set(1024, 1024);
  scene.add(keyLight);

  const rimLight = new THREE.DirectionalLight(0x22c8c8, 3.2);
  rimLight.position.set(-5, 2, -4);
  scene.add(rimLight);

  const warmLight = new THREE.PointLight(0xff6a00, 18, 12, 2);
  warmLight.position.set(3.5, -1.5, 4);
  scene.add(warmLight);

  let dragging = false;
  let previousX = 0;
  let previousY = 0;
  let hasInteracted = false;

  host.addEventListener('pointerdown', (event) => {
    dragging = true;
    hasInteracted = true;
    previousX = event.clientX;
    previousY = event.clientY;
    host.classList.add('is-dragging');
    host.setPointerCapture?.(event.pointerId);
  });

  host.addEventListener('pointermove', (event) => {
    if (!dragging) return;
    const deltaX = event.clientX - previousX;
    const deltaY = event.clientY - previousY;
    model.rotation.y += deltaX * 0.012;
    model.rotation.x = Math.max(-1.15, Math.min(1.15, model.rotation.x + deltaY * 0.008));
    previousX = event.clientX;
    previousY = event.clientY;
  });

  ['pointerup', 'pointercancel'].forEach((type) => {
    host.addEventListener(type, () => {
      dragging = false;
      host.classList.remove('is-dragging');
    });
  });

  host.addEventListener('keydown', (event) => {
    if (!['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(event.key)) return;
    event.preventDefault();
    hasInteracted = true;
    if (event.key === 'ArrowLeft') model.rotation.y -= 0.14;
    if (event.key === 'ArrowRight') model.rotation.y += 0.14;
    if (event.key === 'ArrowUp') model.rotation.x = Math.max(-1.15, model.rotation.x - 0.1);
    if (event.key === 'ArrowDown') model.rotation.x = Math.min(1.15, model.rotation.x + 0.1);
  });

  const resize = () => {
    const width = Math.max(1, host.clientWidth);
    const height = Math.max(1, host.clientHeight);
    const isCompact = width <= 520;
    camera.aspect = width / height;
    camera.position.y = isCompact ? 0.02 : 0.15;
    camera.position.z = isCompact ? 8.7 : 8.2;
    model.scale.setScalar(isCompact ? 0.84 : 0.92);
    if (isCompact && !hasInteracted) model.rotation.y = -0.32;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height, false);
  };

  const resizeObserver = new ResizeObserver(resize);
  resizeObserver.observe(host);
  resize();

  const clock = new THREE.Clock();
  let animationElapsed = 0;
  const render = () => {
    const delta = Math.min(clock.getDelta(), 0.04);
    animationElapsed += delta;
    updateDisplays(animationElapsed);
    if (!dragging && !hasInteracted && host.clientWidth > 520) model.rotation.y += delta * 0.22;
    renderer.render(scene, camera);
    requestAnimationFrame(render);
  };

  host.querySelector('.hero-model-loading')?.remove();
  host.classList.add('is-ready');
  render();
}
