(() => {
  const tabs = [...document.querySelectorAll('[data-download-tab]')];
  const panels = [...document.querySelectorAll('[data-download-panel]')];
  const selectPanel = () => {
    const selected = location.hash === '#manuais-samwha' ? 'manuais-samwha' : 'documentos';
    panels.forEach(panel => { panel.hidden = panel.id !== selected; });
    tabs.forEach(tab => {
      if (tab.hash === '#' + selected) tab.setAttribute('aria-current', 'page');
      else tab.removeAttribute('aria-current');
    });
  };
  window.addEventListener('hashchange', selectPanel);
  selectPanel();
  const normalize = value => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
  const search = document.querySelector('[data-manual-search]');
  search?.addEventListener('input', () => {
    let count = 0;
    const query = normalize(search.value.trim());
    document.querySelectorAll('[data-manual-file]').forEach(file => {
      file.hidden = !normalize(file.textContent).includes(query);
      if (!file.hidden) count++;
    });
    document.querySelector('[data-manual-count]').textContent = count;
    document.querySelector('[data-manual-empty]').hidden = count !== 0;
  });
})();
