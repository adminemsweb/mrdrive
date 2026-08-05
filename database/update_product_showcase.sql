-- Marcadores comerciais usados na vitrine da página inicial.
ALTER TABLE products
    ADD COLUMN is_offer TINYINT(1) NOT NULL DEFAULT 0 AFTER is_featured,
    ADD COLUMN is_best_seller TINYINT(1) NOT NULL DEFAULT 0 AFTER is_offer,
    ADD COLUMN is_new TINYINT(1) NOT NULL DEFAULT 0 AFTER is_best_seller;
