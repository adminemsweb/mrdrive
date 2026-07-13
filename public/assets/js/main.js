document.querySelector('.mobile-menu-toggle')?.addEventListener('click', (event) => {
  const nav = document.querySelector('.mobile-nav');
  if (!nav) return;
  const isOpen = nav.classList.toggle('open');
  event.currentTarget.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
});

document.querySelectorAll('.mobile-nav a').forEach((link) => {
  link.addEventListener('click', () => {
    document.querySelector('.mobile-nav')?.classList.remove('open');
    document.querySelector('.mobile-menu-toggle')?.setAttribute('aria-expanded', 'false');
  });
});

document.querySelectorAll('.mobile-submenu-toggle').forEach((button) => {
  button.addEventListener('click', () => {
    const group = button.closest('.mobile-nav-group');
    if (!group) return;
    const isOpen = group.classList.toggle('open');
    button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });
});

const scrollTopButton = document.querySelector('.scroll-top-button');
if (scrollTopButton) {
  const updateScrollTopButton = () => {
    scrollTopButton.classList.toggle('visible', window.scrollY > 420);
  };

  scrollTopButton.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  updateScrollTopButton();
  window.addEventListener('scroll', updateScrollTopButton, { passive: true });
}

const canvas = document.querySelector('#ambient-canvas');
if (canvas) {
  const ctx = canvas.getContext('2d');
  const particles = [];
  let width = 0;
  let height = 0;
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function resizeCanvas() {
    const ratio = window.devicePixelRatio || 1;
    width = canvas.width = window.innerWidth * ratio;
    height = canvas.height = window.innerHeight * ratio;
    canvas.style.width = `${window.innerWidth}px`;
    canvas.style.height = `${window.innerHeight}px`;
    particles.length = 0;
    const count = Math.min(70, Math.floor(window.innerWidth / 18));
    for (let i = 0; i < count; i += 1) {
      particles.push({
        x: Math.random() * width,
        y: Math.random() * height,
        vx: (Math.random() - 0.5) * 0.18 * ratio,
        vy: (Math.random() - 0.5) * 0.18 * ratio,
        r: (Math.random() * 1.4 + 0.6) * ratio,
      });
    }
  }

  function drawAmbient() {
    if (!ctx) return;
    const ratio = window.devicePixelRatio || 1;
    ctx.clearRect(0, 0, width, height);
    ctx.fillStyle = 'rgba(95, 157, 255, 0.42)';
    ctx.strokeStyle = 'rgba(255, 106, 0, 0.08)';
    ctx.lineWidth = ratio;

    particles.forEach((particle, index) => {
      if (!reduceMotion) {
        particle.x += particle.vx;
        particle.y += particle.vy;
      }
      if (particle.x < 0 || particle.x > width) particle.vx *= -1;
      if (particle.y < 0 || particle.y > height) particle.vy *= -1;

      ctx.beginPath();
      ctx.arc(particle.x, particle.y, particle.r, 0, Math.PI * 2);
      ctx.fill();

      for (let j = index + 1; j < particles.length; j += 1) {
        const other = particles[j];
        const dx = particle.x - other.x;
        const dy = particle.y - other.y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        const limit = 150 * ratio;
        if (distance < limit) {
          ctx.globalAlpha = 1 - distance / limit;
          ctx.beginPath();
          ctx.moveTo(particle.x, particle.y);
          ctx.lineTo(other.x, other.y);
          ctx.stroke();
          ctx.globalAlpha = 1;
        }
      }
    });

    requestAnimationFrame(drawAmbient);
  }

  resizeCanvas();
  drawAmbient();
  window.addEventListener('resize', resizeCanvas);
}

document.querySelectorAll('[data-product]').forEach((link) => {
  link.addEventListener('click', () => {
    const input = document.querySelector('#product_interest');
    if (input) input.value = link.dataset.product || '';
  });
});

document.querySelectorAll('[data-scroll-target]').forEach((button) => {
  button.addEventListener('click', () => {
    const carousel = document.querySelector(button.dataset.scrollTarget || '');
    if (!carousel) return;
    const direction = Number(button.dataset.scrollDirection || 1);
    carousel.scrollBy({
      left: direction * Math.min(380, carousel.clientWidth * 0.82),
      behavior: 'smooth',
    });
  });
});

document.querySelectorAll('[data-drag-scroll]').forEach((carousel) => {
  let isDown = false;
  let startX = 0;
  let scrollLeft = 0;

  carousel.addEventListener('pointerdown', (event) => {
    if (event.target.closest('button')) return;
    isDown = true;
    carousel.classList.add('is-dragging');
    startX = event.clientX;
    scrollLeft = carousel.scrollLeft;
    carousel.setPointerCapture?.(event.pointerId);
  });

  carousel.addEventListener('pointermove', (event) => {
    if (!isDown) return;
    event.preventDefault();
    carousel.scrollLeft = scrollLeft - (event.clientX - startX);
  });

  ['pointerup', 'pointercancel', 'pointerleave'].forEach((type) => {
    carousel.addEventListener(type, () => {
      isDown = false;
      carousel.classList.remove('is-dragging');
    });
  });
});

document.querySelector('#savings-calculator')?.addEventListener('submit', (event) => {
  event.preventDefault();
  const form = event.currentTarget;
  const kwh = Number(form.kwh.value || 0);
  const tariff = Number(form.tariff.value || 0);
  const hours = Number(form.hours.value || 0);
  const power = Number(form.power.value || 0);
  const operatingFactor = Math.min(1, Math.max(0.35, hours / 24));
  const estimatedReduction = 0.18 + Math.min(0.12, power / 1000) + operatingFactor * 0.05;
  const monthlySavings = kwh * tariff * estimatedReduction;
  const yearlySavings = monthlySavings * 12;
  document.querySelector('#savings-result').textContent =
    `Economia estimada: ${monthlySavings.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}/mes ou ${yearlySavings.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}/ano.`;
});

