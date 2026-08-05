-- Contas administrativas individuais e separadas dos clientes da loja.
ALTER TABLE users
    ADD COLUMN role ENUM('owner', 'admin') NOT NULL DEFAULT 'admin' AFTER password,
    ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER role,
    ADD COLUMN last_login_at DATETIME NULL AFTER is_active,
    ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at,
    ADD INDEX idx_users_active_role (is_active, role);

UPDATE users
SET role = 'owner', is_active = 1
WHERE email = 'admin@mrdrives.com.br';
