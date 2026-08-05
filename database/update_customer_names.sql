-- Separa nome e sobrenome sem remover o campo legado de nome completo.
ALTER TABLE customers
    ADD COLUMN first_name VARCHAR(80) NULL AFTER id,
    ADD COLUMN last_name VARCHAR(120) NULL AFTER first_name;

UPDATE customers
SET
    first_name = SUBSTRING_INDEX(TRIM(name), ' ', 1),
    last_name = CASE
        WHEN TRIM(name) LIKE '% %' THEN TRIM(SUBSTRING(TRIM(name), CHAR_LENGTH(SUBSTRING_INDEX(TRIM(name), ' ', 1)) + 1))
        ELSE '-'
    END;

ALTER TABLE customers
    MODIFY COLUMN first_name VARCHAR(80) NOT NULL,
    MODIFY COLUMN last_name VARCHAR(120) NOT NULL;
