UPDATE products
SET main_image = 'assets/img/mrd600/mrd600_2.jpeg'
WHERE main_image IN ('assets/img/mrd600/mrd600.jpeg', 'assets/img/mrd600/mrd600_3.jpeg');

UPDATE products
SET
    name = 'Inversor MRD700/IP65',
    category = 'Inversores de frequência IP65',
    short_description = 'Inversor lavável IP65 para ambientes severos, com STO, comunicação industrial e interfaces completas.',
    full_description = 'O MRD700/IP65 combina gabinete protegido, painel LED com dupla exibição, LCD multilíngue, arquitetura modular e ampla compatibilidade de comunicação para bombas fotovoltaicas, motores síncronos e assíncronos, elevadores, guindastes e máquinas industriais.',
    power = '0.4 kW a 400 kW',
    voltage = '220 V / 380 V / 480 V',
    recommended_applications = 'Bombas fotovoltaicas, motores síncronos, motores assíncronos, elevadores, guindastes, esteiras, ventiladores e ambientes com poeira ou umidade',
    technical_specs = 'Proteção IP65\nFunção STO integrada\n7 terminais multifuncionais\n2 entradas AI\n2 saídas de relé e saída AO\nPT100/PT1000\nPID e PLC integrados\nSVC, V/F, FVC e controle de torque\nRS485, PROFIBUS, PROFINET, CANopen, EtherCAT, Modbus TCP e PG',
    main_image = 'assets/img/mrd700-ip65/mrd700ip65.png',
    is_active = 1,
    is_featured = 1,
    sort_order = 40
WHERE model_code = 'MRD700/IP65';

INSERT INTO products
(name, model_code, category, short_description, full_description, power, voltage, recommended_applications, technical_specs, main_image, manual_pdf, is_active, is_featured, sort_order)
SELECT
    'Inversor MRD700/IP65',
    'MRD700/IP65',
    'Inversores de frequência IP65',
    'Inversor lavável IP65 para ambientes severos, com STO, comunicação industrial e interfaces completas.',
    'O MRD700/IP65 combina gabinete protegido, painel LED com dupla exibição, LCD multilíngue, arquitetura modular e ampla compatibilidade de comunicação para bombas fotovoltaicas, motores síncronos e assíncronos, elevadores, guindastes e máquinas industriais.',
    '0.4 kW a 400 kW',
    '220 V / 380 V / 480 V',
    'Bombas fotovoltaicas, motores síncronos, motores assíncronos, elevadores, guindastes, esteiras, ventiladores e ambientes com poeira ou umidade',
    'Proteção IP65\nFunção STO integrada\n7 terminais multifuncionais\n2 entradas AI\n2 saídas de relé e saída AO\nPT100/PT1000\nPID e PLC integrados\nSVC, V/F, FVC e controle de torque\nRS485, PROFIBUS, PROFINET, CANopen, EtherCAT, Modbus TCP e PG',
    'assets/img/mrd700-ip65/mrd700ip65.png',
    NULL,
    1,
    1,
    40
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE model_code = 'MRD700/IP65'
);

