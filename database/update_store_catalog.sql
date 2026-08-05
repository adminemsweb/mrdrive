-- Catálogo canônico da loja MR Drives.
-- Não remove produtos existentes; cria as linhas oficiais quando ausentes e
-- alinha os dados usados pelas páginas de compra e pelo carrinho.

INSERT INTO products
    (name, model_code, category, short_description, full_description, power, voltage,
     recommended_applications, technical_specs, sku, price, compare_at_price,
     sale_channel, stock_quantity, track_stock, shipping_days, main_image, manual_pdf,
     is_active, is_featured, is_offer, is_best_seller, is_new, sort_order)
SELECT
    'MRD600', 'MRD600', 'Inversores compactos',
    'Inversor compacto para máquinas, bombas, ventiladores e aplicações industriais de rotina.',
    'Inversor vetorial compacto para controle preciso de motores em máquinas, bombas, ventiladores e sistemas industriais.',
    '0.4 kW a 18 kW', '220 V / 380 V',
    'Esteiras, ventiladores, máquinas industriais, bombas e sistemas de embalagem',
    'Controle vetorial\nDisplay duplo LED\nPotenciômetro integrado\nEntradas digitais e analógicas',
    'MRD600', NULL, NULL, 'whatsapp', 0, 0, 'Prazo confirmado no atendimento',
    'assets/img/mrd600/mrd600_2.png', 'assets/img/mrd600/MRD600.pdf',
    1, 1, 0, 1, 0, 10
WHERE NOT EXISTS (SELECT 1 FROM products WHERE model_code = 'MRD600');

INSERT INTO products
    (name, model_code, category, short_description, full_description, power, voltage,
     recommended_applications, technical_specs, sku, price, compare_at_price,
     sale_channel, stock_quantity, track_stock, shipping_days, main_image, manual_pdf,
     is_active, is_featured, is_offer, is_best_seller, is_new, sort_order)
SELECT
    'MRD700', 'MRD700', 'Alto desempenho',
    'Linha vetorial de alto desempenho com expansão PLC e protocolos industriais.',
    'Linha vetorial de alta performance para máquinas e processos com recursos avançados de automação.',
    '0.4 kW a 1000 kW', '220 V / 380 V / 480 V',
    'Máquinas industriais, processos contínuos, elevação e integração com PLC',
    'Controle vetorial\nExpansão PLC\nProtocolos industriais\nAlta capacidade de sobrecarga',
    'MRD700', NULL, NULL, 'whatsapp', 0, 0, 'Prazo confirmado no atendimento',
    'assets/img/mrd700/capa.png', 'assets/img/mrd700/MRD700.pdf',
    1, 1, 1, 1, 0, 20
WHERE NOT EXISTS (SELECT 1 FROM products WHERE model_code = 'MRD700');

INSERT INTO products
    (name, model_code, category, short_description, full_description, power, voltage,
     recommended_applications, technical_specs, sku, price, compare_at_price,
     sale_channel, stock_quantity, track_stock, shipping_days, main_image, manual_pdf,
     is_active, is_featured, is_offer, is_best_seller, is_new, sort_order)
SELECT
    'MRD700/IP65', 'MRD700/IP65', 'Proteção IP65',
    'Inversor lavável para ambientes com água, poeira e rotinas severas de limpeza.',
    'Inversor industrial protegido para ambientes severos, com arquitetura modular e ampla compatibilidade de comunicação.',
    '0.4 kW a 400 kW', '220 V / 380 V / 480 V',
    'Bombas fotovoltaicas, elevadores, guindastes, esteiras, ventiladores e ambientes com poeira ou umidade',
    'Proteção IP65\nFunção STO integrada\nPID e PLC integrados\nRS485, PROFINET, CANopen e EtherCAT',
    'MRD700-IP65', NULL, NULL, 'whatsapp', 0, 0, 'Prazo confirmado no atendimento',
    'assets/img/mrd700-ip65/mrd700ip65-transparent.png', 'assets/img/mrd700/MRD700.pdf',
    1, 1, 0, 1, 1, 30
WHERE NOT EXISTS (SELECT 1 FROM products WHERE model_code = 'MRD700/IP65');

UPDATE products SET
    name = 'MRD600', category = 'Inversores compactos', sku = COALESCE(NULLIF(sku, ''), 'MRD600'),
    sale_channel = IF(price IS NULL OR price <= 0, 'whatsapp', 'cart'), main_image = 'assets/img/mrd600/mrd600_2.png',
    manual_pdf = 'assets/img/mrd600/MRD600.pdf', is_active = 1, is_featured = 1
WHERE model_code = 'MRD600';

UPDATE products SET
    name = 'MRD700', category = 'Alto desempenho', sku = COALESCE(NULLIF(sku, ''), 'MRD700'),
    sale_channel = IF(price IS NULL OR price <= 0, 'whatsapp', 'cart'), main_image = 'assets/img/mrd700/capa.png',
    manual_pdf = 'assets/img/mrd700/MRD700.pdf', is_active = 1, is_featured = 1
WHERE model_code = 'MRD700';

UPDATE products SET
    name = 'MRD700/IP65', category = 'Proteção IP65', sku = COALESCE(NULLIF(sku, ''), 'MRD700-IP65'),
    sale_channel = IF(price IS NULL OR price <= 0, 'whatsapp', 'cart'), main_image = 'assets/img/mrd700-ip65/mrd700ip65-transparent.png',
    manual_pdf = 'assets/img/mrd700/MRD700.pdf', is_active = 1, is_featured = 1
WHERE model_code = 'MRD700/IP65';
