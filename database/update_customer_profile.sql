ALTER TABLE customers
    ADD COLUMN birth_date DATE NULL AFTER email_verification_expires_at,
    ADD COLUMN phone VARCHAR(20) NULL AFTER birth_date,
    ADD COLUMN postal_code VARCHAR(9) NULL AFTER phone,
    ADD COLUMN street VARCHAR(180) NULL AFTER postal_code,
    ADD COLUMN address_number VARCHAR(30) NULL AFTER street,
    ADD COLUMN complement VARCHAR(120) NULL AFTER address_number,
    ADD COLUMN district VARCHAR(120) NULL AFTER complement,
    ADD COLUMN city VARCHAR(120) NULL AFTER district,
    ADD COLUMN state CHAR(2) NULL AFTER city;
