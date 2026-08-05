-- Mantém somente os dois fluxos comerciais disponíveis no painel.
UPDATE products
SET sale_channel = IF(price IS NULL OR price <= 0, 'whatsapp', 'cart')
WHERE sale_channel = 'both';

UPDATE products
SET sale_channel = 'whatsapp'
WHERE sale_channel = 'cart' AND (price IS NULL OR price <= 0);

ALTER TABLE products
    MODIFY COLUMN sale_channel ENUM('whatsapp', 'cart') NOT NULL DEFAULT 'whatsapp';
