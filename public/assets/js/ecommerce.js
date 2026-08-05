(() => {
  'use strict';

  const STORAGE_KEY = 'mrdrives_cart_v1';
  const currency = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });
  const shopConfig = window.MRShop || {};
  const cartEnabled = shopConfig.cartEnabled === true;

  const parseCart = () => {
    try {
      const value = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
      if (!Array.isArray(value)) return [];
      return value.filter((item) => item && item.id && item.name).map((item) => ({
        id: String(item.id),
        name: String(item.name),
        sku: String(item.sku || ''),
        image: String(item.image || ''),
        price: Number.isFinite(Number(item.price)) && item.price !== null && item.price !== '' ? Number(item.price) : null,
        quantity: Math.min(99, Math.max(1, Number(item.quantity) || 1)),
      }));
    } catch (_) {
      return [];
    }
  };

  let cart = cartEnabled ? parseCart() : [];
  if (!cartEnabled) {
    try { localStorage.removeItem(STORAGE_KEY); } catch (_) { /* Navegação privada pode bloquear storage. */ }
  }

  const saveCart = () => {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(cart)); } catch (_) { /* Navegação privada pode bloquear storage. */ }
    renderCart();
    window.dispatchEvent(new CustomEvent('cart:updated', { detail: { quantity: totalQuantity() } }));
  };

  const totalQuantity = () => cart.reduce((sum, item) => sum + item.quantity, 0);
  const pricedSubtotal = () => cart.reduce((sum, item) => sum + (item.price === null ? 0 : item.price * item.quantity), 0);
  const hasQuoteItems = () => cart.some((item) => item.price === null);
  const escapeHtml = (value) => String(value).replace(/[&<>'"]/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[character]));

  const showToast = (message) => {
    document.querySelector('.shop-toast')?.remove();
    const toast = document.createElement('div');
    toast.className = 'shop-toast';
    toast.setAttribute('role', 'status');
    toast.textContent = message;
    document.body.appendChild(toast);
    window.setTimeout(() => toast.remove(), 2600);
  };

  const itemTemplate = (item) => `
    <article class="cart-item" data-cart-item="${escapeHtml(item.id)}">
      <img src="${escapeHtml(item.image)}" alt="">
      <div class="cart-item-info">
        <strong>${escapeHtml(item.name)}</strong>
        <small>SKU ${escapeHtml(item.sku || 'sob consulta')}</small>
        <span>${item.price === null ? 'Preço sob consulta' : currency.format(item.price)}</span>
        <div class="cart-item-controls" aria-label="Quantidade de ${escapeHtml(item.name)}">
          <button type="button" data-cart-decrease aria-label="Diminuir">−</button>
          <span>${item.quantity}</span>
          <button type="button" data-cart-increase aria-label="Aumentar">+</button>
        </div>
      </div>
      <button class="cart-remove" type="button" data-cart-remove aria-label="Remover ${escapeHtml(item.name)}">×</button>
    </article>`;

  const checkoutItemTemplate = (item) => `
    <article class="checkout-item">
      <img src="${escapeHtml(item.image)}" alt="">
      <div><strong>${escapeHtml(item.name)}</strong><small>${item.quantity} × ${item.price === null ? 'sob consulta' : currency.format(item.price)}</small></div>
      <span>${item.price === null ? 'Consultar' : currency.format(item.price * item.quantity)}</span>
    </article>`;

  function renderCart() {
    const quantity = totalQuantity();
    document.querySelectorAll('[data-cart-count]').forEach((node) => { node.textContent = quantity; });
    const itemsContainer = document.querySelector('[data-cart-items]');
    const emptyState = document.querySelector('[data-cart-empty]');
    const footer = document.querySelector('[data-cart-footer]');
    if (itemsContainer) itemsContainer.innerHTML = cart.map(itemTemplate).join('');
    emptyState?.classList.toggle('is-visible', cart.length === 0);
    if (footer) footer.hidden = cart.length === 0;
    document.querySelectorAll('[data-cart-subtotal]').forEach((node) => {
      node.textContent = hasQuoteItems() && pricedSubtotal() === 0 ? 'Sob consulta' : currency.format(pricedSubtotal());
    });
    const priceNote = document.querySelector('[data-cart-price-note]');
    if (priceNote) priceNote.hidden = !hasQuoteItems();
    renderCheckout();
  }

  const openCart = () => {
    const drawer = document.querySelector('[data-cart-drawer]');
    const overlay = document.querySelector('[data-cart-overlay]');
    if (!drawer || !overlay) return;
    overlay.hidden = false;
    requestAnimationFrame(() => {
      drawer.classList.add('is-open');
      overlay.classList.add('is-visible');
    });
    drawer.setAttribute('aria-hidden', 'false');
    document.body.classList.add('cart-is-open');
    drawer.querySelector('[data-cart-close]')?.focus();
  };

  const closeCart = () => {
    const drawer = document.querySelector('[data-cart-drawer]');
    const overlay = document.querySelector('[data-cart-overlay]');
    drawer?.classList.remove('is-open');
    overlay?.classList.remove('is-visible');
    drawer?.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('cart-is-open');
    window.setTimeout(() => { if (overlay && !overlay.classList.contains('is-visible')) overlay.hidden = true; }, 280);
  };

  const addToCart = (button) => {
    if (!cartEnabled || button.disabled) return;
    const quantitySource = button.dataset.quantitySource ? document.querySelector(button.dataset.quantitySource) : null;
    const quantity = Math.min(99, Math.max(1, Number(quantitySource?.value || 1)));
    const priceValue = button.dataset.price;
    const existing = cart.find((item) => item.id === String(button.dataset.id));
    if (existing) {
      existing.quantity = Math.min(99, existing.quantity + quantity);
    } else {
      cart.push({
        id: String(button.dataset.id),
        name: button.dataset.name || 'Produto MR Drives',
        sku: button.dataset.sku || '',
        image: button.dataset.image || '',
        price: priceValue === '' || priceValue === undefined ? null : Number(priceValue),
        quantity,
      });
    }
    saveCart();
    showToast(`${button.dataset.name || 'Produto'} adicionado ao carrinho.`);
    openCart();
  };

  document.addEventListener('click', (event) => {
    const target = event.target;
    if (!(target instanceof Element)) return;
    const addButton = target.closest('[data-add-to-cart]');
    if (addButton) { addToCart(addButton); return; }
    if (target.closest('[data-cart-open]')) { openCart(); return; }
    if (target.closest('[data-cart-close]') || target.closest('[data-cart-overlay]')) { closeCart(); return; }

    const cartItem = target.closest('[data-cart-item]');
    if (cartItem) {
      const item = cart.find((entry) => entry.id === cartItem.dataset.cartItem);
      if (!item) return;
      if (target.closest('[data-cart-increase]')) item.quantity = Math.min(99, item.quantity + 1);
      if (target.closest('[data-cart-decrease]')) item.quantity = Math.max(1, item.quantity - 1);
      if (target.closest('[data-cart-remove]')) cart = cart.filter((entry) => entry.id !== item.id);
      saveCart();
      return;
    }

    const quantityInput = document.querySelector('[data-product-quantity]');
    if (target.closest('[data-qty-minus]') && quantityInput) quantityInput.value = Math.max(1, Number(quantityInput.value || 1) - 1);
    if (target.closest('[data-qty-plus]') && quantityInput) quantityInput.value = Math.min(99, Number(quantityInput.value || 1) + 1);

    const galleryThumb = target.closest('[data-gallery-thumb]');
    if (galleryThumb) {
      const mainImage = document.querySelector('[data-gallery-main]');
      if (mainImage) mainImage.src = galleryThumb.dataset.galleryThumb || mainImage.src;
      document.querySelectorAll('[data-gallery-thumb]').forEach((thumb) => thumb.classList.toggle('is-active', thumb === galleryThumb));
    }
  });

  document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeCart(); });

  const normalize = (value) => String(value || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
  const productGrid = document.querySelector('[data-product-grid]');
  const searchInput = document.querySelector('[data-catalog-search]');
  const sortSelect = document.querySelector('[data-catalog-sort]');
  const priceMinInput = document.querySelector('[data-price-min]');
  const priceMaxInput = document.querySelector('[data-price-max]');
  let selectedCategory = 'all';

  if (searchInput) {
    const currentParams = new URLSearchParams(window.location.search);
    const queryFromUrl = currentParams.get('q') || currentParams.get('category');
    if (queryFromUrl) searchInput.value = queryFromUrl;
  }

  const filterProducts = () => {
    if (!productGrid) return;
    const term = normalize(searchInput?.value);
    const minimumPrice = priceMinInput?.value === '' ? null : Number(priceMinInput?.value);
    const maximumPrice = priceMaxInput?.value === '' ? null : Number(priceMaxInput?.value);
    let visibleCount = 0;
    productGrid.querySelectorAll('[data-product-card]').forEach((card) => {
      const matchesText = !term || normalize(card.dataset.name).includes(term);
      const matchesCategory = selectedCategory === 'all' || normalize(card.dataset.category) === normalize(selectedCategory);
      const hasPrice = card.dataset.price !== '';
      const productPrice = hasPrice ? Number(card.dataset.price) : null;
      const matchesMinimum = minimumPrice === null || (hasPrice && productPrice >= minimumPrice);
      const matchesMaximum = maximumPrice === null || (hasPrice && productPrice <= maximumPrice);
      card.hidden = !(matchesText && matchesCategory && matchesMinimum && matchesMaximum);
      if (!card.hidden) visibleCount += 1;
    });
    document.querySelectorAll('[data-product-result-count]').forEach((node) => { node.textContent = visibleCount; });
    const empty = document.querySelector('[data-empty-results]');
    if (empty) empty.hidden = visibleCount !== 0;
  };

  const sortProducts = () => {
    if (!productGrid || !sortSelect) return;
    const cards = [...productGrid.querySelectorAll('[data-product-card]')];
    const mode = sortSelect.value;
    cards.sort((a, b) => {
      if (mode === 'name') return a.dataset.name.localeCompare(b.dataset.name, 'pt-BR');
      if (mode === 'price-asc' || mode === 'price-desc') {
        const fallback = mode === 'price-asc' ? Number.MAX_SAFE_INTEGER : -1;
        const priceA = a.dataset.price === '' ? fallback : Number(a.dataset.price);
        const priceB = b.dataset.price === '' ? fallback : Number(b.dataset.price);
        return mode === 'price-asc' ? priceA - priceB : priceB - priceA;
      }
      return Number(b.dataset.featured || 0) - Number(a.dataset.featured || 0);
    });
    cards.forEach((card) => productGrid.appendChild(card));
    filterProducts();
  };

  searchInput?.addEventListener('input', filterProducts);
  sortSelect?.addEventListener('change', sortProducts);
  document.querySelector('[data-sidebar-apply]')?.addEventListener('click', filterProducts);
  document.querySelector('[data-category-filters]')?.addEventListener('click', (event) => {
    const button = event.target.closest('[data-category]');
    if (!button) return;
    selectedCategory = button.dataset.category || 'all';
    document.querySelectorAll('[data-category]').forEach((item) => item.classList.toggle('is-active', item === button));
    filterProducts();
  });

  const showcaseViewport = document.querySelector('[data-showcase-viewport]');
  const showcaseCards = [...document.querySelectorAll('[data-showcase-card]')];
  const showcaseProgress = document.querySelector('[data-showcase-progress]');
  const showcaseManagedByFramework = showcaseViewport?.classList.contains('swiper') || false;
  let showcasePaused = false;

  const visibleShowcaseCards = () => showcaseCards;

  const updateShowcaseProgress = () => {
    if (!showcaseViewport || !showcaseProgress) return;
    const maximum = Math.max(1, showcaseViewport.scrollWidth - showcaseViewport.clientWidth);
    const visibleRatio = Math.min(1, showcaseViewport.clientWidth / Math.max(showcaseViewport.scrollWidth, 1));
    const progressWidth = Math.max(18, visibleRatio * 100);
    const travel = Math.max(0, 100 - progressWidth);
    const position = Math.min(1, showcaseViewport.scrollLeft / maximum) * travel;
    showcaseProgress.style.width = `${progressWidth}%`;
    showcaseProgress.style.transform = `translateX(${position / Math.max(progressWidth, 1) * 100}%)`;
  };

  const moveShowcase = (direction = 1) => {
    if (!showcaseViewport) return;
    const cards = visibleShowcaseCards();
    if (cards.length < 2) return;
    const step = cards[0].getBoundingClientRect().width + 20;
    const atEnd = showcaseViewport.scrollLeft + showcaseViewport.clientWidth >= showcaseViewport.scrollWidth - 12;
    const atStart = showcaseViewport.scrollLeft <= 12;
    if (direction > 0 && atEnd) showcaseViewport.scrollTo({ left: 0, behavior: 'smooth' });
    else if (direction < 0 && atStart) showcaseViewport.scrollTo({ left: showcaseViewport.scrollWidth, behavior: 'smooth' });
    else showcaseViewport.scrollBy({ left: direction * step, behavior: 'smooth' });
  };

  if (!showcaseManagedByFramework) {
    document.querySelector('[data-showcase-prev]')?.addEventListener('click', () => moveShowcase(-1));
    document.querySelector('[data-showcase-next]')?.addEventListener('click', () => moveShowcase(1));
    showcaseViewport?.addEventListener('scroll', updateShowcaseProgress, { passive: true });
    showcaseViewport?.addEventListener('mouseenter', () => { showcasePaused = true; });
    showcaseViewport?.addEventListener('mouseleave', () => { showcasePaused = false; });
    showcaseViewport?.addEventListener('focusin', () => { showcasePaused = true; });
    showcaseViewport?.addEventListener('focusout', () => { showcasePaused = false; });
  }

  document.querySelector('.home-showcase-tabs')?.addEventListener('click', (event) => {
    const button = event.target.closest('[data-showcase-filter]');
    if (!button) return;
    const filter = button.dataset.showcaseFilter || 'featured';
    document.querySelectorAll('[data-showcase-filter]').forEach((tab) => {
      const active = tab === button;
      tab.classList.toggle('is-active', active);
      tab.setAttribute('aria-selected', active ? 'true' : 'false');
    });
    const track = document.querySelector('[data-showcase-track]');
    showcaseCards
      .slice()
      .sort((a, b) => Number((b.dataset.showcaseGroups || '').split(' ').includes(filter)) - Number((a.dataset.showcaseGroups || '').split(' ').includes(filter)))
      .forEach((card) => {
        const matches = (card.dataset.showcaseGroups || '').split(' ').includes(filter);
        card.classList.toggle('is-category-match', matches);
        track?.appendChild(card);
      });
    showcaseViewport?.scrollTo({ left: 0, behavior: 'smooth' });
    window.setTimeout(updateShowcaseProgress, 250);
  });

  const hashTabMap = { '#ofertas': 'offers', '#mais-vendidos': 'best', '#lancamentos': 'new', '#destaques': 'featured' };
  const requestedShowcaseFilter = hashTabMap[window.location.hash];
  const initialShowcaseTab = requestedShowcaseFilter
    ? document.querySelector(`[data-showcase-filter="${requestedShowcaseFilter}"]`)
    : document.querySelector('[data-showcase-filter].is-active');
  initialShowcaseTab?.click();

  if (!showcaseManagedByFramework && showcaseViewport && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    window.setInterval(() => { if (!showcasePaused && document.visibilityState === 'visible') moveShowcase(1); }, 5200);
  }

  if (!showcaseManagedByFramework) {
    window.addEventListener('resize', updateShowcaseProgress, { passive: true });
    updateShowcaseProgress();
  }

  if (searchInput?.value) filterProducts();

  function renderCheckout() {
    const container = document.querySelector('[data-checkout-items]');
    if (!container) return;
    if (cart.length === 0) {
      container.innerHTML = '<div class="cart-empty is-visible"><strong>Seu carrinho está vazio</strong><p>Adicione produtos antes de finalizar.</p><a href="/catalogo">Voltar à loja</a></div>';
    } else {
      container.innerHTML = cart.map(checkoutItemTemplate).join('');
    }
    const subtotal = document.querySelector('[data-checkout-subtotal]');
    if (subtotal) subtotal.textContent = hasQuoteItems() && pricedSubtotal() === 0 ? 'Sob consulta' : currency.format(pricedSubtotal());
    const note = document.querySelector('[data-checkout-quote-note]');
    if (note) note.hidden = !hasQuoteItems();
    const submit = document.querySelector('.checkout-submit');
    if (submit) submit.disabled = cart.length === 0;
  }

  document.querySelector('[data-checkout-form]')?.addEventListener('submit', (event) => {
    event.preventDefault();
    if (cart.length === 0) { showToast('Adicione um produto antes de finalizar.'); return; }
    const form = new FormData(event.currentTarget);
    const lines = [
      'Olá! Quero finalizar este pedido na MR Drives:',
      '',
      ...cart.map((item, index) => `${index + 1}. ${item.name} | SKU ${item.sku || '-'} | Qtd. ${item.quantity} | ${item.price === null ? 'preço sob consulta' : currency.format(item.price * item.quantity)}`),
      '',
      `Subtotal publicado: ${pricedSubtotal() > 0 ? currency.format(pricedSubtotal()) : 'sob consulta'}`,
      hasQuoteItems() ? 'Observação: o carrinho possui item(ns) com preço sob consulta.' : '',
      '',
      `Nome/Razão social: ${form.get('name')}`,
      `E-mail: ${form.get('email')}`,
      `WhatsApp: ${form.get('phone')}`,
      `CPF/CNPJ: ${form.get('document') || 'não informado'}`,
      `CEP: ${form.get('postal_code') || 'não informado'}`,
      `Endereço: ${form.get('street') || 'não informado'}, ${form.get('address_number') || 's/n'}${form.get('address_complement') ? ` - ${form.get('address_complement')}` : ''}`,
      `Bairro: ${form.get('district') || 'não informado'}`,
      `Cidade/UF: ${form.get('city') || 'não informado'}/${form.get('state') || '-'}`,
      `Aplicação: ${form.get('application')}`,
      `Urgência: ${form.get('urgency')}`,
      `Observações: ${form.get('notes') || 'nenhuma'}`,
    ].filter(Boolean);
    const url = `https://wa.me/${shopConfig.whatsapp || ''}?text=${encodeURIComponent(lines.join('\n'))}`;
    window.open(url, '_blank', 'noopener');
  });

  renderCart();
  sortProducts();

  const cookieBanner = document.querySelector('[data-cookie-banner]');
  let cookiePreference = null;
  try { cookiePreference = localStorage.getItem('mrdrives_cookie_preference'); } catch (_) { /* storage indisponível */ }
  if (cookieBanner && !cookiePreference) cookieBanner.hidden = false;
  const saveCookiePreference = (value) => {
    try { localStorage.setItem('mrdrives_cookie_preference', value); } catch (_) { /* storage indisponível */ }
    if (cookieBanner) cookieBanner.hidden = true;
  };
  document.querySelector('[data-cookie-accept]')?.addEventListener('click', () => saveCookiePreference('optional-accepted'));
  document.querySelector('[data-cookie-reject]')?.addEventListener('click', () => saveCookiePreference('essential-only'));
})();
