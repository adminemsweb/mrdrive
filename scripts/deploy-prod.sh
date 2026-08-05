#!/usr/bin/env bash
set -euo pipefail

SOURCE_DIR="${1:-/root/mrdrives}"
APP_DIR="/var/www/mrdrives"
STACK_NAME="mrdrives"
SERVICE_NAME="mrdrives_app"
DB_NAME="mrdrives"
DB_USER="mrdrives_user"
DB_PASS_FILE="/root/mrdrives-db-pass.txt"
ADMIN_KEY_FILE="/root/mrdrives-admin-entry-key.txt"

echo "==> MRDRIVES deploy isolado"
echo "Fonte: ${SOURCE_DIR}"
echo "Destino: ${APP_DIR}"

if [ ! -d "$SOURCE_DIR" ]; then
  echo "ERRO: pasta fonte nao encontrada: ${SOURCE_DIR}" >&2
  exit 1
fi

if ! command -v docker >/dev/null 2>&1; then
  echo "ERRO: Docker nao encontrado na VPS." >&2
  exit 1
fi

if ! command -v rsync >/dev/null 2>&1; then
  apt-get update
  DEBIAN_FRONTEND=noninteractive apt-get install -y rsync
fi

mkdir -p "$APP_DIR/public/uploads"

echo "==> Sincronizando somente MRDRIVES"
rsync -a --delete \
  --exclude '.git/' \
  --exclude '.env' \
  --exclude 'mrdrives-deploy.zip' \
  --exclude 'public/uploads/' \
  "$SOURCE_DIR/" "$APP_DIR/"

cd "$APP_DIR"

if [ ! -f "$DB_PASS_FILE" ]; then
  openssl rand -base64 32 | tr -d '/+=' | cut -c1-24 > "$DB_PASS_FILE"
  chmod 600 "$DB_PASS_FILE"
fi

export MRDRIVES_DB_PASSWORD
MRDRIVES_DB_PASSWORD="$(cat "$DB_PASS_FILE")"

if [ ! -f "$ADMIN_KEY_FILE" ]; then
  openssl rand -hex 32 > "$ADMIN_KEY_FILE"
  chmod 600 "$ADMIN_KEY_FILE"
fi

export MRDRIVES_ADMIN_ENTRY_KEY
MRDRIVES_ADMIN_ENTRY_KEY="$(cat "$ADMIN_KEY_FILE")"

MARIADB_CONTAINER="$(docker ps --format '{{.Names}}' | grep '^mariadb_mariadb' | head -n1 || true)"
if [ -n "$MARIADB_CONTAINER" ]; then
  ROOT_PASS="$(docker inspect "$MARIADB_CONTAINER" --format '{{range .Config.Env}}{{println .}}{{end}}' | awk -F= '/^(MARIADB_ROOT_PASSWORD|MYSQL_ROOT_PASSWORD)=/{print $2; exit}')"
  DB_CLIENT="$(docker exec "$MARIADB_CONTAINER" sh -lc 'command -v mariadb || command -v mysql' | head -n1 || true)"

  if [ -n "$ROOT_PASS" ] && [ -n "$DB_CLIENT" ]; then
    echo "==> Garantindo banco separado mrdrives"
    docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${MRDRIVES_DB_PASSWORD}';"
    docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'%'; FLUSH PRIVILEGES;"
    SCHEMA_READY="$(docker exec "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -Nse "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='${DB_NAME}' AND table_name='users';")"
    if [ "$SCHEMA_READY" = "0" ]; then
      echo "==> Inicializando esquema e dados padrao"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/schema.sql
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/seed.sql
    else
      echo "==> Banco existente detectado; preservando dados atuais"
    fi
    if [ -f database/update_mrd700_ip65.sql ]; then
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_mrd700_ip65.sql || true
    fi
    if [ -f database/update_ecommerce.sql ]; then
      echo "==> Atualizando estrutura de produtos para e-commerce"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_ecommerce.sql || true
    fi
    if [ -f database/update_sales_channel.sql ]; then
      echo "==> Adicionando configuração de canal de venda"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_sales_channel.sql || true
    fi
    if [ -f database/update_customer_accounts.sql ]; then
      echo "==> Adicionando contas de clientes"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_customer_accounts.sql
    fi
    CUSTOMER_NAMES_READY="$(docker exec "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -Nse "SELECT COUNT(*) FROM information_schema.columns WHERE table_schema='${DB_NAME}' AND table_name='customers' AND column_name='first_name';")"
    if [ "$CUSTOMER_NAMES_READY" = "0" ] && [ -f database/update_customer_names.sql ]; then
      echo "==> Separando nome e sobrenome das contas de clientes"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_customer_names.sql
    fi
    CUSTOMER_VERIFICATION_READY="$(docker exec "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -Nse "SELECT COUNT(*) FROM information_schema.columns WHERE table_schema='${DB_NAME}' AND table_name='customers' AND column_name='email_verified_at';")"
    if [ "$CUSTOMER_VERIFICATION_READY" = "0" ] && [ -f database/update_customer_email_verification.sql ]; then
      echo "==> Adicionando confirmação de e-mail das contas de clientes"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_customer_email_verification.sql
    fi
    CUSTOMER_PROFILE_READY="$(docker exec "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -Nse "SELECT COUNT(*) FROM information_schema.columns WHERE table_schema='${DB_NAME}' AND table_name='customers' AND column_name='birth_date';")"
    if [ "$CUSTOMER_PROFILE_READY" = "0" ] && [ -f database/update_customer_profile.sql ]; then
      echo "==> Adicionando perfil e endereço das contas de clientes"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_customer_profile.sql
    fi
    ADMIN_ROLES_READY="$(docker exec "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -Nse "SELECT COUNT(*) FROM information_schema.columns WHERE table_schema='${DB_NAME}' AND table_name='users' AND column_name='role';")"
    if [ "$ADMIN_ROLES_READY" = "0" ] && [ -f database/update_admin_users.sql ]; then
      echo "==> Adicionando perfis e status da equipe administrativa"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_admin_users.sql
    fi
    if [ -f database/update_product_showcase.sql ]; then
      echo "==> Atualizando marcadores da vitrine de produtos"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_product_showcase.sql || true
    fi
    if [ -f database/update_store_catalog.sql ]; then
      echo "==> Alinhando catálogo oficial da loja"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_store_catalog.sql || true
    fi
    if [ -f database/update_sale_channel_rule.sql ]; then
      echo "==> Aplicando regra de venda por WhatsApp ou loja"
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_sale_channel_rule.sql || true
    fi
  else
    echo "AVISO: MariaDB encontrado, mas senha root/client nao foram detectados. Pulando migracao."
  fi
else
  echo "AVISO: container mariadb_mariadb nao encontrado. Pulando migracao."
fi

echo "==> Build da imagem MRDRIVES"
docker build -t mrdrives-app:latest .

echo "==> Deploy do stack MRDRIVES"
docker stack deploy -c docker-compose.yml "$STACK_NAME"
docker service update --force --image mrdrives-app:latest "$SERVICE_NAME"

echo "==> Aguardando servico"
for i in $(seq 1 30); do
  if docker service ps "$SERVICE_NAME" --format '{{.CurrentState}} {{.Error}}' | head -n1 | grep -q '^Running'; then
    break
  fi
  sleep 2
done

docker service ls | grep "$SERVICE_NAME" || true

echo "==> Teste local via Traefik"
if curl -k -fsS --resolve "mrdrives.com.br:443:127.0.0.1" https://mrdrives.com.br/ >/tmp/mrdrives-home.html; then
  if grep -q '<title>MRDRIVES' /tmp/mrdrives-home.html; then
    echo "OK: MRDRIVES esta respondendo na VPS pelo Traefik."
  else
    echo "AVISO: respondeu, mas o titulo esperado nao apareceu."
  fi
else
  echo "ERRO: teste local via Traefik falhou." >&2
  docker service logs "$SERVICE_NAME" --tail 80 || true
  exit 1
fi

echo "Deploy finalizado. Nao alterou Realize, Samwha ou outros stacks."
