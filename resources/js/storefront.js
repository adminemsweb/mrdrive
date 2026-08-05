import 'vite/modulepreload-polyfill';
import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { A11y, Autoplay, Keyboard, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import {
  BadgeCheck,
  BookOpen,
  ChevronLeft,
  ChevronRight,
  ChevronDown,
  ChevronUp,
  CreditCard,
  CircuitBoard,
  FileText,
  Gauge,
  Headphones,
  LockKeyhole,
  LayoutGrid,
  Mail,
  MapPin,
  Menu,
  MessageCircle,
  Package,
  PackageCheck,
  QrCode,
  RotateCcw,
  Search,
  Settings,
  ShieldCheck,
  ShoppingCart,
  Truck,
  UserPlus,
  UserRound,
  createIcons,
} from 'lucide';
import '../css/framework-enhancements.css';

window.Alpine = Alpine;
Alpine.data('marketplaceSearch', () => ({
  focused: false,
  open() { this.focused = true; },
  close() { this.focused = false; },
}));
Alpine.start();

createIcons({
  icons: {
    BadgeCheck,
    BookOpen,
    ChevronLeft,
    ChevronRight,
    ChevronDown,
    ChevronUp,
    CreditCard,
    CircuitBoard,
    FileText,
    Gauge,
    Headphones,
    LockKeyhole,
    LayoutGrid,
    Mail,
    MapPin,
    Menu,
    MessageCircle,
    Package,
    PackageCheck,
    QrCode,
    RotateCcw,
    Search,
    Settings,
    ShieldCheck,
    ShoppingCart,
    Truck,
    UserPlus,
    UserRound,
  },
  attrs: {
    'aria-hidden': 'true',
    'stroke-width': 1.8,
  },
});

const privacyNavigation = document.querySelector('.legal-page--privacy .legal-layout > aside');
if (privacyNavigation) {
  const privacyLinks = [...privacyNavigation.querySelectorAll('a[href^="#"]')];
  const privacyTargets = privacyLinks
    .map((link) => document.querySelector(link.getAttribute('href')))
    .filter(Boolean);

  const activatePrivacyLink = (targetId) => {
    privacyLinks.forEach((link) => {
      const active = link.getAttribute('href') === `#${targetId}`;
      link.classList.toggle('is-active', active);
      if (active) link.setAttribute('aria-current', 'true');
      else link.removeAttribute('aria-current');
    });
  };

  const privacyObserver = new IntersectionObserver((entries) => {
    const visible = entries
      .filter((entry) => entry.isIntersecting)
      .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
    if (visible) activatePrivacyLink(visible.target.id);
  }, { rootMargin: '-20% 0px -58% 0px', threshold: [0, .15, .4] });

  privacyTargets.forEach((section) => privacyObserver.observe(section));
}

const homeCatalogSection = document.querySelector('#catalogo');
const homeProtectedProductSection = document.querySelector('.mrd-home-video');

if (homeCatalogSection && homeProtectedProductSection) {
  homeProtectedProductSection.before(homeCatalogSection);
}

const heroCarousel = document.querySelector('[data-hero-carousel]');

if (heroCarousel) {
  new Swiper(heroCarousel, {
    modules: [A11y, Autoplay, Keyboard, Pagination],
    slidesPerView: 1,
    initialSlide: 1,
    speed: 650,
    loop: true,
    keyboard: { enabled: true, onlyInViewport: true },
    autoplay: {
      delay: 5200,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: '.storefront-hero-pagination',
      clickable: true,
    },
    a11y: {
      enabled: true,
      prevSlideMessage: 'Produto anterior',
      nextSlideMessage: 'Próximo produto',
      paginationBulletMessage: 'Ir para o produto {{index}}',
    },
  });
}

const showcase = document.querySelector('.home-showcase-viewport.swiper');
let showcaseSwiper = null;

if (showcase) {
  showcaseSwiper = new Swiper(showcase, {
    modules: [A11y, Autoplay, Keyboard, Navigation, Pagination],
    slidesPerView: 1.12,
    spaceBetween: 14,
    speed: 620,
    grabCursor: true,
    watchOverflow: true,
    keyboard: { enabled: true, onlyInViewport: true },
    a11y: {
      enabled: true,
      prevSlideMessage: 'Produto anterior',
      nextSlideMessage: 'Próximo produto',
      firstSlideMessage: 'Primeiro produto',
      lastSlideMessage: 'Último produto',
    },
    autoplay: {
      delay: 5200,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    navigation: {
      prevEl: '[data-showcase-prev]',
      nextEl: '[data-showcase-next]',
    },
    pagination: {
      el: '.home-showcase-progress',
      type: 'progressbar',
    },
    breakpoints: {
      640: { slidesPerView: 2, spaceBetween: 16 },
      920: { slidesPerView: 3, spaceBetween: 18 },
      1220: { slidesPerView: 3, spaceBetween: 20 },
    },
  });
}

const feedbackSwiper = document.querySelector('[data-feedback-swiper]');

if (feedbackSwiper) {
  new Swiper(feedbackSwiper, {
    modules: [A11y, Autoplay, Keyboard, Pagination],
    slidesPerView: 1,
    spaceBetween: 14,
    speed: 700,
    loop: true,
    grabCursor: true,
    keyboard: { enabled: true, onlyInViewport: true },
    autoplay: {
      delay: 3200,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: '.feedback-swiper-pagination',
      clickable: true,
    },
    breakpoints: {
      640: { slidesPerView: 2, spaceBetween: 16 },
      1024: { slidesPerView: 3, spaceBetween: 18 },
    },
    a11y: {
      enabled: true,
      prevSlideMessage: 'Avaliação anterior',
      nextSlideMessage: 'Próxima avaliação',
      paginationBulletMessage: 'Ir para a avaliação {{index}}',
    },
  });
}

const shopReviewSwiper = document.querySelector('[data-shop-review-swiper]');
if (shopReviewSwiper) {
  new Swiper(shopReviewSwiper, {
    modules: [A11y, Autoplay, Keyboard, Pagination],
    slidesPerView: 1.08,
    spaceBetween: 14,
    speed: 650,
    loop: true,
    grabCursor: true,
    keyboard: { enabled: true, onlyInViewport: true },
    autoplay: { delay: 3600, disableOnInteraction: false, pauseOnMouseEnter: true },
    pagination: { el: '.shop-review-pagination', clickable: true },
    breakpoints: {
      640: { slidesPerView: 2, spaceBetween: 15 },
      1024: { slidesPerView: 3, spaceBetween: 15 },
    },
    a11y: {
      enabled: true,
      prevSlideMessage: 'Avaliação anterior',
      nextSlideMessage: 'Próxima avaliação',
      paginationBulletMessage: 'Ir para a avaliação {{index}}',
    },
  });
}

const shippingCalculator = document.querySelector('[data-shipping-calculator]');
if (shippingCalculator) {
  const cepInput = shippingCalculator.querySelector('[data-shipping-cep]');
  const result = shippingCalculator.querySelector('[data-shipping-result]');

  cepInput?.addEventListener('input', () => {
    const digits = cepInput.value.replace(/\D/g, '').slice(0, 8);
    cepInput.value = digits.length > 5 ? `${digits.slice(0, 5)}-${digits.slice(5)}` : digits;
  });

  shippingCalculator.addEventListener('submit', async (event) => {
    event.preventDefault();
    const digits = cepInput?.value.replace(/\D/g, '') || '';
    if (digits.length !== 8) {
      result.textContent = 'Digite um CEP válido com 8 números.';
      result.classList.add('is-error');
      cepInput?.focus();
      return;
    }

    const button = shippingCalculator.querySelector('button[type="submit"]');
    button.disabled = true;
    result.textContent = 'Consultando CEP e opções de entrega...';
    result.classList.remove('is-error');

    try {
      const response = await fetch(`/api/frete?cep=${encodeURIComponent(digits)}`, { headers: { Accept: 'application/json' } });
      const data = await response.json();
      if (!response.ok || !data.ok) throw new Error(data.message || 'Não foi possível consultar o frete.');

      const place = [data.address?.city, data.address?.state].filter(Boolean).join('/');
      if (Array.isArray(data.rates) && data.rates.length) {
        const rates = data.rates.map((rate) => {
          const deadline = rate.days ? ` — ${rate.days} dia${rate.days === 1 ? '' : 's'} úteis` : '';
          return `${rate.service}: R$ ${rate.price}${deadline}`;
        }).join(' | ');
        result.textContent = `${place ? `${place} — ` : ''}${rates}`;
      } else {
        result.textContent = `${place ? `${place}. ` : ''}${data.message}`;
      }
    } catch (error) {
      result.textContent = error.message || 'Não foi possível consultar o CEP agora.';
      result.classList.add('is-error');
    } finally {
      button.disabled = false;
    }
  });
}

const cepLookup = document.querySelector('[data-cep-lookup]');
if (cepLookup) {
  const cepInput = cepLookup.querySelector('[data-cep-input]');
  const lookupButton = cepLookup.querySelector('[data-cep-button]');
  const status = cepLookup.querySelector('[data-cep-status]');
  const fields = {
    street: cepLookup.querySelector('[data-address-street]'),
    district: cepLookup.querySelector('[data-address-district]'),
    city: cepLookup.querySelector('[data-address-city]'),
    state: cepLookup.querySelector('[data-address-state]'),
  };
  let lastLookup = '';

  const maskCep = () => {
    const digits = cepInput.value.replace(/\D/g, '').slice(0, 8);
    cepInput.value = digits.length > 5 ? `${digits.slice(0, 5)}-${digits.slice(5)}` : digits;
    return digits;
  };

  const findAddress = async () => {
    const digits = maskCep();
    if (digits.length !== 8) {
      status.textContent = 'Digite um CEP válido com 8 números.';
      status.classList.add('is-error');
      cepInput.focus();
      return;
    }

    lookupButton.disabled = true;
    status.textContent = 'Localizando endereço...';
    status.classList.remove('is-error', 'is-success');
    try {
      const response = await fetch(`/api/cep?cep=${encodeURIComponent(digits)}`, { headers: { Accept: 'application/json' } });
      const data = await response.json();
      if (!response.ok || !data.ok) throw new Error(data.message || 'CEP não encontrado.');
      Object.entries(fields).forEach(([key, input]) => { if (input) input.value = data.address?.[key] || ''; });
      lastLookup = digits;
      status.textContent = 'Endereço localizado. Confira os dados e informe o número.';
      status.classList.add('is-success');
      cepLookup.querySelector('[name="address_number"]')?.focus();
    } catch (error) {
      status.textContent = error.message || 'Não foi possível localizar este CEP.';
      status.classList.add('is-error');
    } finally {
      lookupButton.disabled = false;
    }
  };

  if (cepInput) maskCep();
  cepInput?.addEventListener('input', () => {
    const digits = maskCep();
    if (digits.length === 8 && digits !== lastLookup) findAddress();
  });
  cepInput?.addEventListener('blur', () => { if (maskCep().length === 8 && !fields.city?.value) findAddress(); });
  lookupButton?.addEventListener('click', findAddress);
}

document.querySelectorAll('.customer-profile-form input[name="phone"]').forEach((input) => {
  const maskPhone = () => {
    const digits = input.value.replace(/\D/g, '').slice(0, 11);
    if (digits.length <= 2) input.value = digits;
    else if (digits.length <= 6) input.value = `(${digits.slice(0, 2)}) ${digits.slice(2)}`;
    else if (digits.length <= 10) input.value = `(${digits.slice(0, 2)}) ${digits.slice(2, 6)}-${digits.slice(6)}`;
    else input.value = `(${digits.slice(0, 2)}) ${digits.slice(2, 7)}-${digits.slice(7)}`;
  };
  maskPhone();
  input.addEventListener('input', maskPhone);
});

const headerCep = document.querySelector('[data-header-cep]');
if (headerCep) {
  const input = headerCep.querySelector('[data-header-cep-input]');
  const label = headerCep.querySelector('[data-header-cep-label]');
  const status = headerCep.querySelector('[data-header-cep-status]');
  const submit = headerCep.querySelector('button[type="submit"]');

  const mask = () => {
    const digits = input.value.replace(/\D/g, '').slice(0, 8);
    input.value = digits.length > 5 ? `${digits.slice(0, 5)}-${digits.slice(5)}` : digits;
    return digits;
  };

  const locate = async (postalCode, restore = false) => {
    if (postalCode.length !== 8) {
      status.textContent = 'CEP inválido';
      status.classList.add('is-error');
      input.focus();
      return;
    }

    submit.disabled = true;
    status.textContent = restore ? '' : 'Localizando...';
    status.classList.remove('is-error');
    try {
      const response = await fetch(`/api/cep?cep=${encodeURIComponent(postalCode)}`, { headers: { Accept: 'application/json' } });
      const data = await response.json();
      if (!response.ok || !data.ok) throw new Error(data.message || 'CEP não encontrado');
      const location = [data.address?.city, data.address?.state].filter(Boolean).join(' / ');
      const addressSummary = [data.address?.street, data.address?.district, location].filter(Boolean).join(' • ');
      label.textContent = data.address?.street || location || input.value;
      label.title = addressSummary;
      status.textContent = restore ? '' : addressSummary;
      status.classList.add('is-success');
      try { localStorage.setItem('mrdrives_delivery_cep', postalCode); } catch (_) { /* armazenamento indisponível */ }
      if (!restore) input.blur();
    } catch (error) {
      label.textContent = 'Informe seu CEP';
      label.removeAttribute('title');
      status.textContent = error.message || 'CEP não encontrado';
      status.classList.add('is-error');
    } finally {
      submit.disabled = false;
    }
  };

  input?.addEventListener('input', () => {
    mask();
    label.textContent = 'Informe seu CEP';
    label.removeAttribute('title');
    status.textContent = '';
    status.classList.remove('is-error', 'is-success');
  });
  headerCep.addEventListener('submit', (event) => {
    event.preventDefault();
    locate(mask());
  });

  try {
    const savedPostalCode = (localStorage.getItem('mrdrives_delivery_cep') || '').replace(/\D/g, '').slice(0, 8);
    if (savedPostalCode.length === 8) {
      input.value = `${savedPostalCode.slice(0, 5)}-${savedPostalCode.slice(5)}`;
      locate(savedPostalCode, true);
    }
  } catch (_) { /* armazenamento indisponível */ }
}

const productNewsletter = document.querySelector('[data-product-newsletter]');
if (productNewsletter) {
  productNewsletter.addEventListener('submit', (event) => {
    event.preventDefault();
    const input = productNewsletter.querySelector('input[type="email"]');
    const message = productNewsletter.querySelector('p');
    if (!input?.validity.valid) {
      message.textContent = 'Digite um e-mail válido.';
      message.classList.add('is-error');
      input?.focus();
      return;
    }

    message.textContent = 'Cadastro realizado com sucesso.';
    message.classList.remove('is-error');
    productNewsletter.reset();
  });
}

document.querySelector('.home-showcase-tabs')?.addEventListener('click', () => {
  window.setTimeout(() => {
    showcaseSwiper?.update();
    showcaseSwiper?.slideTo(0, 480);
  }, 0);
});

window.addEventListener('cart:updated', () => {
  document.querySelector('.header-cart-button')?.animate(
    [{ transform: 'scale(1)' }, { transform: 'scale(1.06)' }, { transform: 'scale(1)' }],
    { duration: 320, easing: 'ease-out' },
  );
});
