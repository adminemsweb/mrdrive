ALTER TABLE customers
    ADD COLUMN email_verified_at DATETIME NULL AFTER password,
    ADD COLUMN email_verification_token CHAR(64) NULL AFTER email_verified_at,
    ADD COLUMN email_verification_expires_at DATETIME NULL AFTER email_verification_token,
    ADD INDEX idx_customers_verification_token (email_verification_token);
