-- Execute uma única vez em instalações criadas antes da versão e-commerce.
ALTER TABLE products
    ADD COLUMN sku VARCHAR(120) NULL AFTER technical_specs,
    ADD COLUMN price DECIMAL(12,2) NULL AFTER sku,
    ADD COLUMN compare_at_price DECIMAL(12,2) NULL AFTER price,
    ADD COLUMN stock_quantity INT UNSIGNED NOT NULL DEFAULT 0 AFTER compare_at_price,
    ADD COLUMN track_stock TINYINT(1) NOT NULL DEFAULT 0 AFTER stock_quantity,
    ADD COLUMN shipping_days VARCHAR(80) NULL AFTER track_stock,
    ADD UNIQUE INDEX idx_products_sku (sku);
