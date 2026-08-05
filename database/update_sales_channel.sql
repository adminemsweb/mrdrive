-- Execute uma única vez em bancos existentes.
ALTER TABLE products
    ADD COLUMN sale_channel ENUM('whatsapp', 'cart') NOT NULL DEFAULT 'whatsapp' AFTER compare_at_price;
