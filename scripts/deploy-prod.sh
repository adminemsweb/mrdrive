#!/usr/bin/env bash
set -euo pipefail

SOURCE_DIR="${1:-/root/mrdrives}"
APP_DIR="/var/www/mrdrives"
STACK_NAME="mrdrives"
SERVICE_NAME="mrdrives_app"
DB_NAME="mrdrives"
DB_USER="mrdrives_user"
DB_PASS_FILE="/root/mrdrives-db-pass.txt"

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

MARIADB_CONTAINER="$(docker ps --format '{{.Names}}' | grep '^mariadb_mariadb' | head -n1 || true)"
if [ -n "$MARIADB_CONTAINER" ]; then
  ROOT_PASS="$(docker inspect "$MARIADB_CONTAINER" --format '{{range .Config.Env}}{{println .}}{{end}}' | awk -F= '/^(MARIADB_ROOT_PASSWORD|MYSQL_ROOT_PASSWORD)=/{print $2; exit}')"
  DB_CLIENT="$(docker exec "$MARIADB_CONTAINER" sh -lc 'command -v mariadb || command -v mysql' | head -n1 || true)"

  if [ -n "$ROOT_PASS" ] && [ -n "$DB_CLIENT" ]; then
    echo "==> Garantindo banco separado mrdrives"
    docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${MRDRIVES_DB_PASSWORD}';"
    docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'%'; FLUSH PRIVILEGES;"
    docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/schema.sql
    docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/seed.sql
    if [ -f database/update_mrd700_ip65.sql ]; then
      docker exec -i "$MARIADB_CONTAINER" "$DB_CLIENT" -uroot -p"$ROOT_PASS" "$DB_NAME" < database/update_mrd700_ip65.sql || true
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
if curl -k -fsS -H "Host: mrdrives.com.br" https://127.0.0.1/ >/tmp/mrdrives-home.html; then
  if grep -q '<title>MRDRIVES</title>' /tmp/mrdrives-home.html; then
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
