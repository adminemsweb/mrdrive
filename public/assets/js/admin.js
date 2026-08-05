const normalizeText = (value) => value
  .toLocaleLowerCase('pt-BR')
  .normalize('NFD')
  .replace(/[\u0300-\u036f]/g, '');

const sidebar = document.querySelector('.admin-sidebar');
const menuButton = document.querySelector('[data-admin-menu]');

menuButton?.addEventListener('click', () => {
  const isOpen = sidebar?.classList.toggle('is-open') ?? false;
  menuButton.setAttribute('aria-expanded', String(isOpen));
});

document.addEventListener('click', (event) => {
  if (window.innerWidth > 900 || !sidebar?.classList.contains('is-open')) return;
  if (!sidebar.contains(event.target) && !menuButton?.contains(event.target)) {
    sidebar.classList.remove('is-open');
    menuButton?.setAttribute('aria-expanded', 'false');
  }
});

const productRows = [...document.querySelectorAll('[data-product-row]')];
const productSearch = document.querySelector('[data-product-search]');
const productStatus = document.querySelector('[data-product-status]');
const productChannel = document.querySelector('[data-product-channel]');
const productCount = document.querySelector('[data-product-count]');
const productEmpty = document.querySelector('[data-product-empty]');

const filterProducts = () => {
  const search = normalizeText(productSearch?.value.trim() ?? '');
  const status = productStatus?.value ?? 'all';
  const channel = productChannel?.value ?? 'all';
  let visible = 0;

  productRows.forEach((row) => {
    const rowSearch = normalizeText(row.dataset.search ?? '');
    const matches = (!search || rowSearch.includes(search))
      && (status === 'all' || row.dataset.status === status)
      && (channel === 'all' || row.dataset.channel === channel);
    row.hidden = !matches;
    if (matches) visible += 1;
  });

  if (productCount) productCount.textContent = `${visible} ${visible === 1 ? 'produto' : 'produtos'}`;
  if (productEmpty) productEmpty.hidden = visible !== 0;
};

[productSearch, productStatus, productChannel].forEach((control) => {
  control?.addEventListener(control === productSearch ? 'input' : 'change', filterProducts);
});

const saleChannel = document.querySelector('[data-sale-channel]');
const saleHint = document.querySelector('[data-sale-hint]');
const directSaleFields = document.querySelector('[data-direct-sale-fields]');

const updateSaleChannel = () => {
  if (!saleChannel || !saleHint || !directSaleFields) return;
  const direct = saleChannel.value === 'cart';
  directSaleFields.classList.toggle('is-muted', !direct);
  saleHint.className = `admin-sale-hint ${direct ? 'is-store' : 'is-whatsapp'}`;
  saleHint.innerHTML = direct
    ? '<strong>Venda direta pela loja</strong><span>Informe um preço maior que zero. O cliente poderá adicionar o produto ao carrinho.</span>'
    : '<strong>Venda assistida pelo WhatsApp</strong><span>O preço ficará oculto e o cliente será direcionado para falar com a equipe.</span>';
};

saleChannel?.addEventListener('change', updateSaleChannel);
updateSaleChannel();

const imageInput = document.querySelector('[data-image-input]');
const imagePreview = document.querySelector('[data-image-preview]');
let imagePreviewUrl = null;

imageInput?.addEventListener('change', () => {
  const file = imageInput.files?.[0];
  if (!file || !imagePreview) return;
  if (imagePreviewUrl) URL.revokeObjectURL(imagePreviewUrl);
  imagePreviewUrl = URL.createObjectURL(file);
  imagePreview.innerHTML = '';
  const image = document.createElement('img');
  image.src = imagePreviewUrl;
  image.alt = 'Prévia da nova imagem principal';
  imagePreview.append(image);
});

const fileInput = document.querySelector('[data-file-input]');
const fileName = document.querySelector('[data-file-name]');
fileInput?.addEventListener('change', () => {
  if (fileName) fileName.textContent = fileInput.files?.[0]?.name ?? 'Nenhum arquivo selecionado';
});

const galleryInput = document.querySelector('[data-gallery-input]');
const galleryCount = document.querySelector('[data-gallery-count]');
galleryInput?.addEventListener('change', () => {
  const count = galleryInput.files?.length ?? 0;
  if (galleryCount) galleryCount.textContent = count ? `${count} ${count === 1 ? 'imagem selecionada' : 'imagens selecionadas'}` : 'Nenhuma nova imagem';
});

document.querySelectorAll('.admin-flash').forEach((flash) => {
  window.setTimeout(() => flash.classList.add('is-hiding'), 5000);
});
