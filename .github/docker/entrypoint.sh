#!/bin/ash
set -eu
mkdir -p /app/var /app/storage/framework/cache /app/storage/framework/sessions /app/storage/framework/views /app/storage/logs
if [ ! -f /app/var/.env ]; then
    php /app/artisan key:generate --show --no-ansi > /tmp/lunar-key
    printf 'APP_KEY=%s\n' "$(cat /tmp/lunar-key)" > /app/var/.env
    rm -f /tmp/lunar-key
fi
export APP_KEY="$(sed -n 's/^APP_KEY=//p' /app/var/.env | head -n1)
"
until nc -z "${DB_HOST:-mariadb}" "${DB_PORT:-3306}" 2>/dev/null; do sleep 2; done
php /app/artisan storage:link --force >/dev/null 2>&1 || true
if [ "${LUNAR_AUTO_MIGRATE:-true}" = "true" ]; then
    php /app/artisan migrate --force --no-interaction
fi
exec "$@"
