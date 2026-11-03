-- Dados da linha MRD600 conforme revisão comercial e técnica.
UPDATE products
SET power = '0,4 kW a 7,5 kW',
    voltage = '220 V / 380 V',
    technical_specs = '1 ano de garantia
Saída para resistor de frenagem incorporada
Comunicação Modbus RS485 incorporada
Filtros EMC C2/C3 incorporados
IHM LED e LCD para instalação remota (opcional)'
WHERE model_code = 'MRD600';
