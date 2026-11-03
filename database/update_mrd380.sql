-- MRD-380: cadastro inicial sem sobrescrever alterações administrativas.
INSERT INTO products (name, model_code, sku, category, short_description, power, voltage, main_image, manual_pdf, full_description, recommended_applications, technical_specs, price, compare_at_price, sale_channel, stock_quantity, track_stock, shipping_days, is_featured, is_offer, is_best_seller, is_new, is_active, sort_order)
SELECT 'MRD-380', 'MRD-380', 'MRD-380', 'Soft starters', 'Soft starter com bypass integrado para partida e parada suave de motores industriais.', '5,5 kW a 115 kW', '220 V / 380 V, conforme modelo', 'assets/img/mrd380/mrd380-transparente.png', 'assets/img/mrd380/MRD-380-catalogo-pt-BR.pdf', 'A MRD-380 é uma soft starter para partida e parada suave de motores, com bypass integrado, painel LCD e comunicação Modbus RS485. O dimensionamento considera a tensão, a corrente nominal do motor e a aplicação. Faixas da linha: 5,5–18,5 kW; 22–37 kW; 45–75 kW; 90–115 kW. Em 220 V, o catálogo informa modelos de 5,5 a 55 kW; em 380 V, de 5,5 a 115 kW.', 'Motores assíncronos trifásicos, bombas e sistemas industriais que exigem partida suave', 'Bypass integrado
Partida por rampa de tensão, limitação de corrente e torque
Parada suave ajustável
Display LCD e painel removível
Comunicação Modbus RS485
Proteções de sobrecarga, falta de fase, sequência de fase, sobretensão e subtensão
Faixas: 5,5–18,5 / 22–37 / 45–75 / 90–115 kW
220 V: 5,5 a 55 kW | 380 V: 5,5 a 115 kW', NULL, NULL, 'whatsapp', 0, 0, 'Prazo e disponibilidade confirmados no atendimento', 1, 0, 0, 1, 1, 40
WHERE NOT EXISTS (SELECT 1 FROM products WHERE model_code = 'MRD-380');

-- Atualiza apenas o documento legado, preservando dados comerciais e edições do painel.
UPDATE products
SET manual_pdf = 'assets/img/mrd380/MRD-380-catalogo-pt-BR.pdf'
WHERE model_code = 'MRD-380'
  AND (manual_pdf IS NULL OR manual_pdf = '' OR manual_pdf IN ('assets/img/mrd380/manual-380.pdf', 'assets/img/mrd380/MRD-380-catalogo.pdf'));

-- Foto principal oficial do MRD-380.
UPDATE products
SET main_image = 'assets/img/mrd380/mrd380-transparente.png'
WHERE model_code = 'MRD-380';
